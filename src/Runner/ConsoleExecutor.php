<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 2:50
 */

namespace A12\Runner;


use A12\Exceptions\ExecutorException;
use Garden\Cli\Cli;
use A12\Interfaces\Configuration\ConfigProviderInterface;
use A12\Interfaces\Exceptions\BasicExceptionInterface;
use A12\Interfaces\IO\ConfirmInterface;
use A12\Interfaces\IO\InputInterface;
use A12\Interfaces\IO\OutputStyleInterface;
use A12\Interfaces\IO\ProgramOutputInterface;
use A12\Interfaces\IO\UserOutputInterface;
use A12\Interfaces\Middleware\MiddlewareInterface;
use A12\Interfaces\Program\BasicProgramInterface;
use A12\Interfaces\Program\ExecAssistantInterface;
use A12\Interfaces\Request\RequestInterface;
use A12\Interfaces\Response\ResponseInterface;
use A12\Modules\Container\Container;
use A12\Modules\IO\Console\ConsoleConfirm;
use A12\Modules\IO\Console\ConsoleInput;
use A12\Modules\IO\Console\ConsoleProgramOutput;
use A12\Modules\IO\Console\ConsoleUserOutput;
use A12\Modules\Pipeline\Pipeline;
use A12\Modules\Request\Request;
use A12\Modules\Response\Response;
use Psr\Container\ContainerInterface;

class ConsoleExecutor implements ExecAssistantInterface
{
    /** @var BasicProgramInterface */
    private $instance;
    /** @var RequestInterface */
    private $exeRequest;
    /** @var ResponseInterface */
    private $exeResponse;
    /** @var Cli */
    private $exeCli;
    /** @var ContainerInterface */
    private $container;
    /** @var string */
    private $exeEntryPoint;
    /** @var string */
    private $exeId;
    /** @var array */
    private $exeArgv;
    
    /**
     * ConsoleExecutor constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        global $argv;
        
        $this->exeArgv = $argv;
        $this->exeCli = new Cli();
        $this->exeCli
            ->opt('force:f', 'Force executing.', false, 'boolean')
            ->opt('silent:s', 'Silent executing.', false, 'boolean')
            ->opt('verbose:v', 'More information.', false, 'boolean')
            ->opt('output:O', 'Output response.', false, 'boolean')
            ->opt('confirm:c', 'Confirm on start executing.', false, 'boolean');
    }
    
    public function setEntryPoint(string $executable)
    {
        $this->exeEntryPoint = $executable;
        return $this;
    }
    
    public function setId(string $id)
    {
        $this->exeId = $id;
        return $this;
    }
    
    public function setArgv(array $argv)
    {
        $this->exeArgv = $argv;
        return $this;
    }
    
    /**
     * @return Cli
     */
    public function setCli()
    {
        return $this->exeCli;
    }
    
    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function start()
    {
        switch (true) {
            case is_null($this->exeEntryPoint) :
                exit("EntryPoint not defined");
            case is_null($this->exeId) :
                exit("EntryPoint ID not defined");
            default :
                $this->execute();
        }
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function execute()
    {
        $this->initContainer();
        // ------- ------- -------
        try {
            
            $this->instance = $this->createInstance($this->exeEntryPoint);
            $response = $this->processResponse();
            // ------- ------- -------
            $this->processExit($response);
            
        } catch (BasicExceptionInterface $e) {
            $this->processExit($e);
        }
    }
    
    /**
     * @param $targetClass
     * @return mixed
     * @throws ExecutorException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function createInstance($targetClass)
    {
        if (!class_exists($targetClass)) {
            throw new ExecutorException("Target class '$targetClass' not found");
        }
        
        if (!method_exists($targetClass, 'main')) {
            throw new ExecutorException("'$targetClass'->main()' method not found in program");
        }
        
        return new $targetClass($this->exeRequest, $this->exeResponse);
    }
    
    /**
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function processResponse()
    {
        /** @var MiddlewareInterface[] */
        $middleware = $this->instance->middleware();
        
        // ------- ------- -------
        
        $pipeline = new Pipeline();
        
        foreach (is_array($middleware) ? $middleware : [$middleware] as $middleware) {
            $pipeline->pipe($middleware);
        }
        
        $this->exeResponse = $pipeline($this->exeRequest, function () {
            return $this->instance->main();
        });
        
        return $this->exeResponse;
    }
    
    /**
     * @param $response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function processExit($response)
    {
        $userOutput     = $this->container->get(UserOutputInterface::class);
        $programOutput  = $this->container->get(ProgramOutputInterface::class);
        
        if ($response instanceof ResponseInterface) {
            
            $this->exeResponse->setAttribute(ResponseInterface::K_BLOCK, 'default');
    
        } elseif ($response instanceof \Throwable) {
            
            $userOutput->writeLine($response->getMessage(), OutputStyleInterface::ERROR);
            $this->exeResponse->setAttribute(ResponseInterface::K_BLOCK, get_class($response));
            $this->exeResponse->setCode($response->getCode() ?: 1);
    
        } else {
    
            $this->exeResponse->setAttribute(ResponseInterface::K_BLOCK, 'undefined');
            $this->exeResponse->setCode(1);
        }
    
        $this->exeResponse->setAttribute(ResponseInterface::K_ID, $this->exeId);
        $this->exeResponse->setAttribute(ResponseInterface::K_CODE, $this->exeResponse->getCode());
        
        $content = $this->exeResponse->getContent();
        
        ksort($content);
        
        $programOutput->writeLine(json_encode($content));
        
        exit($this->exeResponse->getAttribute(ResponseInterface::K_CODE));
    }
    
    /**
     * @throws \Exception
     */
    private function initContainer()
    {
        $this->container = new Container();
        // ------- ------- -------
        $this->exeRequest = new Request($this->exeArgv, $this->exeCli->parse($this->exeArgv, true));
        $this->exeRequest->setAttribute(RequestInterface::KEY_ID, $this->exeId);
        $this->container->set(RequestInterface::class, $this->exeRequest);
        // ------- ------- -------
        $this->exeResponse = new Response([], 0);
        $this->container->set(ResponseInterface::class, $this->exeResponse);
        // ------- ------- -------
        if (!$this->container->has(Cli::class)) {
            $this->container->set(Cli::class, function () {
                return $this->exeCli;
            });
        }
        // ------- ------- -------
        if (!$this->container->has(UserOutputInterface::class)) {
            $this->container->set(UserOutputInterface::class, function () {
                return new ConsoleUserOutput();
            });
        }
        // ------- ------- -------
        if (!$this->container->has(ProgramOutputInterface::class)) {
            $this->container->set(ProgramOutputInterface::class, function () {
                return new ConsoleProgramOutput($this->exeRequest->getOpt('output', false));
            });
        }
        // ------- ------- -------
        if (!$this->container->has(InputInterface::class)) {
            $this->container->set(InputInterface::class, function () {
                return new ConsoleInput();
            });
        }
        // ------- ------- -------
        if (!$this->container->has(ConfirmInterface::class)) {
            $this->container->set(ConfirmInterface::class, function () {
                return new ConsoleConfirm();
            });
        }
        // ------- ------- -------
        if (!$this->container->has(ConfigProviderInterface::class)) {
            $this->container->set(ConfigProviderInterface::class, function () {
//            $cfgData = include(dirname(__DIR__, 2) . '/config/vars.php');
//            return new ConsoleConfirm($cfgData);
            });
        }
    }
}
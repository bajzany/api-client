## API client

#### Instalation

- Composer instalation
````bash
composer require bajzany/api-client dev-master
````

- Register into Nette Application

````neon
extensions:
	ApiClientExtension: Bajzany\ApiClient\DI\ApiClientExtension
````
 	
 	
#### How to use

- first create api request action class witch extended `Bajzany\ApiClient\Model\EndPoint` like `Bajzany\ApiClient\Example\UpdateUserApi`

	````php
	<?php
    
    namespace Bajzany\ApiClient\Example;
    
    use Bajzany\ApiClient\Model\EndPoint;
    use Bajzany\ApiClient\Provider;
    use Bajzany\ApiClient\Response;
    
    class UpdateUserApi extends EndPoint
    {
    
    	const METHOD = Provider::METHOD_POST;
    
    	/**
    	 * @var int
    	 */
    	private $userId;
    
    	/**
    	 * @var array
    	 */
    	private $data;
    
    	public function __construct(int $userId, array $data)
    	{
    		$this->userId = $userId;
    		$this->data = $data;
    	}
    
    	/**
    	 * @return string
    	 */
    	public function getUrl(): string
    	{
    		return "http://crm.d/test/user-update/{$this->userId}";
    	}
    
    	/**
    	 * @param Provider $provider
    	 * @return mixed
    	 * @internal
    	 */
    	public function processRawRequest(Provider $provider): array
    	{
    		return $this->data;
    	}
    
    	/**
    	 * @param Provider $provider
    	 * @return Response|mixed
    	 * @throws \GuzzleHttp\Exception\GuzzleException
    	 */
    	public function execute(Provider $provider)
    	{
    		return parent::execute($provider);
    	}
    }

	````
	- const METHOD set request method etc ('POST', 'GET', 'PUT', 'DELETE')
	- function getUrl set request url
	- function processRawRequest pass into request body data
	- function execute can be replace own execute events
	
- For run this action must be injected service `Bajzany\ApiClient\Provider`
	````php
	/** @var Provider @inject */
	public $provider;
	````

- Now you can run this action like this:

	````php
	$updateUserApi = new UpdateUserApi($userId, [$myData]);
	$response = $updateUserApi->execute($this->provider);	
	````
	
- Into provider can be place events in request and response has been created
	````php
	$this->provider->onRequest[] = function (Provider $provider, EndPoint $endPoint, $response) {
		.....
	};
	$this->provider->onResponse[] = function (Provider $provider, EndPoint $endPoint, $response) {
		.....
	};
	````

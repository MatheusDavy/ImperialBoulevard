<?php 
namespace App\Http\Middleware;
use Closure;
class API {
	
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];
	
    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }

    public function handle($request, Closure $next)
    {
			$this->removeUnwantedHeaders($this->unwantedHeaderList);

            $response = $next($request);
            try {
                $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Content-Range, Content-Disposition, Content-Description, X-Auth-Token');
                $response->header('Access-Control-Allow-Origin', '*');
                $response->header('Referrer-Policy', 'no-referrer-when-downgrade');
                $response->header('X-Content-Type-Options', 'nosniff');
                $response->header('X-XSS-Protection', '1; mode=block');
                $response->header('X-Frame-Options', 'DENY');
                $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            } catch (\Throwable $th) {
                $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Content-Range, Content-Disposition, Content-Description, X-Auth-Token');
                $response->headers->set('Access-Control-Allow-Origin', '*');
                $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
                $response->headers->set('X-Content-Type-Options', 'nosniff');
                $response->headers->set('X-XSS-Protection', '1; mode=block');
                $response->headers->set('X-Frame-Options', 'DENY');
                $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            }
			
			/*$response->header('Content-Security-Policy', "default-src 'none'; script-src 'self'; connect-src 'self'; img-src 'self'; style-src 'self';base-uri 'self';form-action 'self'"); // Clearly, you will be more elaborate here.*/
		
            //add more headers here
            return $response;
        }
}
<?php

declare(strict_types=1);

namespace Pimcorecasts\Bundle\MjmlTemplate\Services;

use Qferrer\Mjml\ApiInterface;
use Qferrer\Mjml\Http\Curl;
use Qferrer\Mjml\Http\CurlInterface;
use Qferrer\Mjml\Exception\ApiException;

/**
 * @see https://mjml.io/api/documentation/
 */
final class DockerMjmlApi implements ApiInterface
{
    protected string $apiEndpoint = "http://mjml";
    protected string $appId;
    protected string $secretKey;
    protected string $credentials;
    protected CurlInterface|Curl $curl;

    /**
     * @param string $appId
     * @param string $secretKey
     * @param CurlInterface|null $curl
     */
    public function __construct(string $appId, string $secretKey, ?CurlInterface $curl = null)
    {
        if (!\extension_loaded('curl')) {
            throw new \LogicException(sprintf(
                'You cannot use the "%s" as the "curl" extension is not installed.',
                DockerMjmlApi::class
            ));
        }

        $this->appId = $appId;
        $this->secretKey = $secretKey;
        $this->credentials = base64_encode("$appId:$secretKey");
        $this->curl = $curl ?? new Curl();
    } //: __construct

    /**
     * @param string $mjml
     * @return string
     */
    public function getHtml(string $mjml): string
    {
        $data = $this->getResult($mjml);

        return $data['html'] ?? '';
    } //: getHtml

    /**
     * @return string
     */
    public function getMjmlVersion(): string
    {
        $data = $this->getResult('<mjml></mjml>');

        return $data['mjml_version'] ?? 'unknown';
    } //: getMjmlVersion

    /**
     * @param string $mjml
     * @return array
     */
    private function getResult(string $mjml): array
    {
        $response = $this->curl->request($this->apiEndpoint, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $mjml,
            CURLOPT_HTTPHEADER => [
                "Content-Type: text/html"
            ]
        ]);

        $data['html'] = $response->getContent();

        if ( null === $data ) {
            throw new ApiException(sprintf(
                'Unable to decode the JSON response: "%s".',
                json_last_error_msg()
            ));
        }

        $httpCode = $response->getStatusCode();

        if ($httpCode !== 200) {
            throw new ApiException(sprintf(
                'Unexpected HTTP code: %s. Api Error Message: "%s".',
                $httpCode,
                $data['message'] ?? 'Unknown Error'
            ));
        }

        return $data;
    } //: getResult
}

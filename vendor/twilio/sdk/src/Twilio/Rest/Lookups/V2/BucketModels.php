<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Lookups
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Lookups\V2;

use Twilio\Values;
abstract class BucketModels
{
    /**
     * @property int $limit Limit of requests for the bucket
     * @property int $ttl Time to live of the rule
    */
    public static function createRateLimitRequest(array $payload = []): RateLimitRequest
    {
        return new RateLimitRequest($payload);
    }

}

class RateLimitRequest implements \JsonSerializable
{
    /**
     * @property int $limit Limit of requests for the bucket
     * @property int $ttl Time to live of the rule
    */
        protected $limit;
        protected $ttl;
    public function __construct(array $payload = []) {
        $this->limit = Values::array_get($payload, 'limit');
        $this->ttl = Values::array_get($payload, 'ttl');
    }

    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize(): array
    {
        return [
            'limit' => $this->limit,
            'ttl' => $this->ttl
        ];
    }
}


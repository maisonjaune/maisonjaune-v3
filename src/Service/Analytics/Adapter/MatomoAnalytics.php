<?php

namespace App\Service\Analytics\Adapter;

use App\Service\Analytics\AnalyticsAdapterInterface;
use App\Service\Analytics\Exception\DataUnavailableException;
use App\Service\Analytics\Model\Visit;
use App\Service\Analytics\Model\VisitCollection;
use DateTimeImmutable;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MatomoAnalytics implements AnalyticsAdapterInterface
{
    /**
     * @var array<string, VisitCollection|null>
     */
    private array $data = [
        self::KEY_VISITS => null,
        self::KEY_UNIQUE_VISITS => null,
    ];

    private const KEY_VISITS = 'visits';

    private const KEY_UNIQUE_VISITS = 'unique_visits';

    public function __construct(
        #[Autowire('%matomo.base_url%')] private string   $baseUrl,
        #[Autowire('%matomo.auth_token%')] private string $authToken,
        #[Autowire('%matomo.id_site%')] private int       $idSite,
    )
    {
    }

    public function getVisitsSummary(): VisitCollection
    {
        if (null === $this->data[self::KEY_VISITS]) {
            $this->computeVisits();
        }

        if (null === $this->data[self::KEY_VISITS]) {
            throw new DataUnavailableException('Unable to compute visits');
        }

        return $this->data[self::KEY_VISITS];
    }

    public function getUniqueVisitsSummary(): VisitCollection
    {
        if (null === $this->data[self::KEY_UNIQUE_VISITS]) {
            $this->computeVisits();
        }

        if (null === $this->data[self::KEY_UNIQUE_VISITS]) {
            throw new DataUnavailableException('Unable to compute unique visits');
        }

        return $this->data[self::KEY_UNIQUE_VISITS];
    }

    private function computeVisits(): void
    {
        $data = $this->get('VisitsSummary.get', [
            'period' => 'day',
            'date' => 'last7',
        ]);

        $this->data = [
            self::KEY_VISITS => new VisitCollection(),
            self::KEY_UNIQUE_VISITS => new VisitCollection(),
        ];

        foreach ($data as $date => $value) {
            $datetime = new DateTimeImmutable($date);

            $this->data[self::KEY_VISITS]->add(new Visit($datetime, (int)($value['nb_visits'] ?? 0)));
            $this->data[self::KEY_UNIQUE_VISITS]->add(new Visit($datetime, (int)($value['nb_uniq_visitors'] ?? 0)));
        }
    }

    /**
     * @param string $method
     * @param array<string, mixed> $context
     * @return array<string, array<string, string|int>>
     */
    private function get(string $method, array $context = []): array
    {
        $query = array_merge([
            'module' => 'API',
            'format' => 'JSON',
            'token_auth' => $this->authToken,
            'idSite' => $this->idSite,
            'method' => $method,
        ], $context);

        $fetched = file_get_contents(sprintf("%s?%s", $this->baseUrl, http_build_query($query)));

        if (false === $fetched) {
            throw new DataUnavailableException(sprintf('Unable to fetch data from %s', $this->baseUrl));
        }

        $json = json_decode($fetched, true);

        return is_array($json) ? $json : [];
    }
}
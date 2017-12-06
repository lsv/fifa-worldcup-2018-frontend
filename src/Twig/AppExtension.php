<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('selectedtimezone', function(Request $request) {
                $params = $request->isMethod('POST') ? $request->request : $request->query;
                if ($params->has('tz')) {
                    return $params->get('tz');
                }

                return date_default_timezone_get();
            }),
            new TwigFunction('timezones', function() {
                $locations = [];
                foreach (\DateTimeZone::listIdentifiers() as $zone) {
                    $zone = explode('/', $zone);
                    if (
                        isset($zone[1])
                        && $zone[1] !== ''
                        && \in_array($zone[0], ['Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific'], true)
                    ) {
                        $locations[$zone[0]][$zone[0]. '/' . $zone[1]] = str_replace('_', ' ', $zone[1]);
                    }
                }
                return $locations;
            }),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('country', function($countryCode, $locale) {
                if ($countryCode === 'gb-eng') {
                    return $this->translator->trans('England');
                }

                return Intl::getRegionBundle()->getCountryName(strtoupper($countryCode), $locale);
            }),
            new TwigFilter('full_localdate', function(\DateTime $dateTime) {
                return $dateTime->format('Y-m-d H:i');
            }),
            new TwigFilter('localdate', function(\DateTime $dateTime) {
                return $dateTime->format('m-d H:i');
            }),
        ];
    }

}

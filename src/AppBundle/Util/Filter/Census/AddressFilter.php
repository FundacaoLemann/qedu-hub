<?php

namespace AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AddressFilter extends AbstractExtension
{
	public function addressFilter(School $school)
    {
        $address = $school->getAddress();
        $district = $school->getDistrict();
        $cep = $school->getAddressCep();

        if (!$address) {
            return 'Não informado';
        }

        $addressFormatted = $address;
        
        if ($district) {
            $addressFormatted .= sprintf('<br/>Bairro: %s', $district);
        }

        if ($cep) {
            $addressFormatted .= sprintf('<br/>CEP: %s', $cep);
        }

        return $addressFormatted;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('addressFilter', [$this, 'addressFilter']),
        ];
    }
}

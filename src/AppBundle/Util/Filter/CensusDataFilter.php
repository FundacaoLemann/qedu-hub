<?php

namespace AppBundle\Util\Filter;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CensusDataFilter extends AbstractExtension
{
    public function phoneFilter(School $school)
    {
        $phone = $school->getPhone();
        $ddd = $school->getDdd();

        if (!$phone || !$ddd) {
            return 'Não informado';
        }

        $phoneFormatted = '(' . $ddd . ') ' . substr($phone, 0, 4) . '-' . substr($phone, 4, 4);

        return $phoneFormatted;
    }

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

    public function optionalNumberTranslationFilter($number)
    {
        if (is_null($number)) {
            return '-';
        }

        return $number;
    }

    public function convertBooleanToYesNoFilter($answer)
    {
        if ($answer === true) {
            return "<span style='color: darkgreen'>Sim</span>";
        } elseif ($answer === false) {
            return "<span style='color: red'>Não</span>";
        }

        return "<span style='color: #666'>Não informado</span>";
    }

    public function waterSupplierFilter($censusServices)
    {
        if ($censusServices->hasWaterPublicNetwork()) {
            return 'Rede pública';
        } elseif ($censusServices->hasArtesianWellWater()) {
            return 'Poço artesiano';
        } elseif ($censusServices->hasWaterReservoir()) {
            return 'Cacimba';
        } elseif ($censusServices->hasWaterRiver()) {
            return 'Rio';
        } elseif ($censusServices->hasNotWater()) {
            return 'Inexistente';
        }

        return 'Não informado';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('phoneFilter', [$this, 'phoneFilter']),
            new TwigFilter('addressFilter', [$this, 'addressFilter']),
            new TwigFilter('optionalNumberTranslationFilter', [$this, 'optionalNumberTranslationFilter']),
            new TwigFilter('convertNumberToYesNoFilter', [$this, 'convertNumberToYesNoFilter']),
            new TwigFilter('waterSupplierFilter', [$this, 'waterSupplierFilter']),
        ];
    }
}

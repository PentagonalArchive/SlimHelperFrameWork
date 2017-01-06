<?php
namespace Pentagonal\SlimHelper\Utilities;

/**
 * Class TimeZone
 * @package Pentagonal\SlimHelper\Utilities
 */
class TimeZone implements \IteratorAggregate
{
    const COUNTRY_CODE = 'country_code';
    const LATITUDE     = 'latitude';
    const LONGITUDE    = 'longitude';
    const ABBREVIATION = 'abbreviation';
    const OFFSET       = 'offset';
    const GMT_OFFSET   = 'gmt_offset';
    const ZONE_NAME    = 'zone_name';

    /**
     * Time Zone Lists
     * @uses \DateTimeZone::listIdentifiers()
     * @var array
     */
    public $time_zone_list = [
        'Africa/Abidjan' => [
            'country_code' => 'CI',
            'latitude'     => 5.31666,
            'longitude'    => -4.03334,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Accra' => [
            'country_code' => 'GH',
            'latitude'     => 5.55,
            'longitude'    => -0.21666999999999,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Addis_Ababa' => [
            'country_code' => 'ET',
            'latitude'     => 9.03333,
            'longitude'    => 38.7,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Algiers' => [
            'country_code' => 'DZ',
            'latitude'     => 36.78333,
            'longitude'    => 3.05,
            'abbreviation' => 'WET',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Asmara' => [
            'country_code' => 'ER',
            'latitude'     => 15.33333,
            'longitude'    => 38.88333,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Bamako' => [
            'country_code' => 'ML',
            'latitude'     => 12.65,
            'longitude'    => -8,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Bangui' => [
            'country_code' => 'CF',
            'latitude'     => 4.36666,
            'longitude'    => 18.58333,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Banjul' => [
            'country_code' => 'GM',
            'latitude'     => 13.46666,
            'longitude'    => -16.65,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Bissau' => [
            'country_code' => 'GW',
            'latitude'     => 11.85,
            'longitude'    => -15.58334,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Blantyre' => [
            'country_code' => 'MW',
            'latitude'     => -15.78334,
            'longitude'    => 35,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Brazzaville' => [
            'country_code' => 'CG',
            'latitude'     => -4.26667,
            'longitude'    => 15.28333,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Bujumbura' => [
            'country_code' => 'BI',
            'latitude'     => -3.38334,
            'longitude'    => 29.36666,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Cairo' => [
            'country_code' => 'EG',
            'latitude'     => 30.05,
            'longitude'    => 31.25,
            'abbreviation' => 'EET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Casablanca' => [
            'country_code' => 'MA',
            'latitude'     => 33.65,
            'longitude'    => -7.58334,
            'abbreviation' => 'WET',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Ceuta' => [
            'country_code' => 'ES',
            'latitude'     => 35.88333,
            'longitude'    => -5.31667,
            'abbreviation' => 'WET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Conakry' => [
            'country_code' => 'GN',
            'latitude'     => 9.51666,
            'longitude'    => -13.71667,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Dakar' => [
            'country_code' => 'SN',
            'latitude'     => 14.66666,
            'longitude'    => -17.43334,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Dar_es_Salaam' => [
            'country_code' => 'TZ',
            'latitude'     => -6.8,
            'longitude'    => 39.28333,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Djibouti' => [
            'country_code' => 'DJ',
            'latitude'     => 11.6,
            'longitude'    => 43.15,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Douala' => [
            'country_code' => 'CM',
            'latitude'     => 4.05,
            'longitude'    => 9.7,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/El_Aaiun' => [
            'country_code' => 'EH',
            'latitude'     => 27.15,
            'longitude'    => -13.2,
            'abbreviation' => 'WET',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Freetown' => [
            'country_code' => 'SL',
            'latitude'     => 8.5,
            'longitude'    => -13.25,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Gaborone' => [
            'country_code' => 'BW',
            'latitude'     => -24.65001,
            'longitude'    => 25.91666,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Harare' => [
            'country_code' => 'ZW',
            'latitude'     => -17.83334,
            'longitude'    => 31.05,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Johannesburg' => [
            'country_code' => 'ZA',
            'latitude'     => -26.25,
            'longitude'    => 28,
            'abbreviation' => 'SAST',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Juba' => [
            'country_code' => 'SS',
            'latitude'     => 4.85,
            'longitude'    => 31.6,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Kampala' => [
            'country_code' => 'UG',
            'latitude'     => 0.31666,
            'longitude'    => 32.41666,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Khartoum' => [
            'country_code' => 'SD',
            'latitude'     => 15.6,
            'longitude'    => 32.53333,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Kigali' => [
            'country_code' => 'RW',
            'latitude'     => -1.95,
            'longitude'    => 30.06666,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Kinshasa' => [
            'country_code' => 'CD',
            'latitude'     => -4.3,
            'longitude'    => 15.3,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Lagos' => [
            'country_code' => 'NG',
            'latitude'     => 6.45,
            'longitude'    => 3.4,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Libreville' => [
            'country_code' => 'GA',
            'latitude'     => 0.38333,
            'longitude'    => 9.45,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Lome' => [
            'country_code' => 'TG',
            'latitude'     => 6.13333,
            'longitude'    => 1.21666,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Luanda' => [
            'country_code' => 'AO',
            'latitude'     => -8.8,
            'longitude'    => 13.23333,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Lubumbashi' => [
            'country_code' => 'CD',
            'latitude'     => -11.66667,
            'longitude'    => 27.46666,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Lusaka' => [
            'country_code' => 'ZM',
            'latitude'     => -15.41667,
            'longitude'    => 28.28333,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Malabo' => [
            'country_code' => 'GQ',
            'latitude'     => 3.75,
            'longitude'    => 8.78333,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Maputo' => [
            'country_code' => 'MZ',
            'latitude'     => -25.96667,
            'longitude'    => 32.58333,
            'abbreviation' => 'CAT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Maseru' => [
            'country_code' => 'LS',
            'latitude'     => -29.46667,
            'longitude'    => 27.5,
            'abbreviation' => 'SAST',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Mbabane' => [
            'country_code' => 'SZ',
            'latitude'     => -26.3,
            'longitude'    => 31.1,
            'abbreviation' => 'SAST',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Mogadishu' => [
            'country_code' => 'SO',
            'latitude'     => 2.06666,
            'longitude'    => 45.36666,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Monrovia' => [
            'country_code' => 'LR',
            'latitude'     => 6.3,
            'longitude'    => -10.78334,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Nairobi' => [
            'country_code' => 'KE',
            'latitude'     => -1.28334,
            'longitude'    => 36.81666,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Africa/Ndjamena' => [
            'country_code' => 'TD',
            'latitude'     => 12.11666,
            'longitude'    => 15.05,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Niamey' => [
            'country_code' => 'NE',
            'latitude'     => 13.51666,
            'longitude'    => 2.11666,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Nouakchott' => [
            'country_code' => 'MR',
            'latitude'     => 18.1,
            'longitude'    => -15.95,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Ouagadougou' => [
            'country_code' => 'BF',
            'latitude'     => 12.36666,
            'longitude'    => -1.51667,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Porto-Novo' => [
            'country_code' => 'BJ',
            'latitude'     => 6.48333,
            'longitude'    => 2.61666,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Sao_Tome' => [
            'country_code' => 'ST',
            'latitude'     => 0.33333,
            'longitude'    => 6.73333,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Africa/Tripoli' => [
            'country_code' => 'LY',
            'latitude'     => 32.9,
            'longitude'    => 13.18333,
            'abbreviation' => 'EET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Africa/Tunis' => [
            'country_code' => 'TN',
            'latitude'     => 36.8,
            'longitude'    => 10.18333,
            'abbreviation' => 'PMT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Africa/Windhoek' => [
            'country_code' => 'NA',
            'latitude'     => -22.56667,
            'longitude'    => 17.1,
            'abbreviation' => 'WAT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'America/Adak' => [
            'country_code' => 'US',
            'latitude'     => 51.88,
            'longitude'    => -176.65806,
            'abbreviation' => 'NWT',
            'offset'       => -32400,
            'gmt_offset'   => -9,
        ],
        'America/Anchorage' => [
            'country_code' => 'US',
            'latitude'     => 61.21805,
            'longitude'    => -149.90028,
            'abbreviation' => 'YST',
            'offset'       => -28800,
            'gmt_offset'   => -8,
        ],
        'America/Anguilla' => [
            'country_code' => 'AI',
            'latitude'     => 18.2,
            'longitude'    => -63.06667,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Antigua' => [
            'country_code' => 'AG',
            'latitude'     => 17.05,
            'longitude'    => -61.8,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Araguaina' => [
            'country_code' => 'BR',
            'latitude'     => -7.2,
            'longitude'    => -48.2,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Buenos_Aires' => [
            'country_code' => 'AR',
            'latitude'     => -34.6,
            'longitude'    => -58.45,
            'abbreviation' => 'CMT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Catamarca' => [
            'country_code' => 'AR',
            'latitude'     => -28.46667,
            'longitude'    => -65.78334,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Cordoba' => [
            'country_code' => 'AR',
            'latitude'     => -31.4,
            'longitude'    => -64.18334,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Jujuy' => [
            'country_code' => 'AR',
            'latitude'     => -24.18334,
            'longitude'    => -65.3,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/La_Rioja' => [
            'country_code' => 'AR',
            'latitude'     => -29.43334,
            'longitude'    => -66.85,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Mendoza' => [
            'country_code' => 'AR',
            'latitude'     => -32.88334,
            'longitude'    => -68.81667,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Rio_Gallegos' => [
            'country_code' => 'AR',
            'latitude'     => -51.63334,
            'longitude'    => -69.21667,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Salta' => [
            'country_code' => 'AR',
            'latitude'     => -24.78334,
            'longitude'    => -65.41667,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/San_Juan' => [
            'country_code' => 'AR',
            'latitude'     => -31.53334,
            'longitude'    => -68.51667,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/San_Luis' => [
            'country_code' => 'AR',
            'latitude'     => -33.31667,
            'longitude'    => -66.35,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Tucuman' => [
            'country_code' => 'AR',
            'latitude'     => -26.81667,
            'longitude'    => -65.21667,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Argentina/Ushuaia' => [
            'country_code' => 'AR',
            'latitude'     => -54.8,
            'longitude'    => -68.3,
            'abbreviation' => 'WART',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Aruba' => [
            'country_code' => 'AW',
            'latitude'     => 12.5,
            'longitude'    => -69.96667,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Asuncion' => [
            'country_code' => 'PY',
            'latitude'     => -25.26667,
            'longitude'    => -57.66667,
            'abbreviation' => 'PYT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Atikokan' => [
            'country_code' => 'CA',
            'latitude'     => 48.75861,
            'longitude'    => -91.62167,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Bahia' => [
            'country_code' => 'BR',
            'latitude'     => -12.98334,
            'longitude'    => -38.51667,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Bahia_Banderas' => [
            'country_code' => 'MX',
            'latitude'     => 20.8,
            'longitude'    => -105.25,
            'abbreviation' => 'PST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Barbados' => [
            'country_code' => 'BB',
            'latitude'     => 13.1,
            'longitude'    => -59.61667,
            'abbreviation' => 'BMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Belem' => [
            'country_code' => 'BR',
            'latitude'     => -1.45,
            'longitude'    => -48.48334,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Belize' => [
            'country_code' => 'BZ',
            'latitude'     => 17.5,
            'longitude'    => -88.2,
            'abbreviation' => 'CST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Blanc-Sablon' => [
            'country_code' => 'CA',
            'latitude'     => 51.41666,
            'longitude'    => -57.11667,
            'abbreviation' => 'AWT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Boa_Vista' => [
            'country_code' => 'BR',
            'latitude'     => 2.81666,
            'longitude'    => -60.66667,
            'abbreviation' => 'AMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Bogota' => [
            'country_code' => 'CO',
            'latitude'     => 4.6,
            'longitude'    => -74.08334,
            'abbreviation' => 'COT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Boise' => [
            'country_code' => 'US',
            'latitude'     => 43.61361,
            'longitude'    => -116.2025,
            'abbreviation' => 'PST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Cambridge_Bay' => [
            'country_code' => 'CA',
            'latitude'     => 69.11388,
            'longitude'    => -105.05278,
            'abbreviation' => 'ZZZ',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Campo_Grande' => [
            'country_code' => 'BR',
            'latitude'     => -20.45,
            'longitude'    => -54.61667,
            'abbreviation' => 'AMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Cancun' => [
            'country_code' => 'MX',
            'latitude'     => 21.08333,
            'longitude'    => -86.76667,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Caracas' => [
            'country_code' => 'VE',
            'latitude'     => 10.5,
            'longitude'    => -66.93334,
            'abbreviation' => 'VET',
            'offset'       => -16200,
            'gmt_offset'   => -4.5,
        ],
        'America/Cayenne' => [
            'country_code' => 'GF',
            'latitude'     => 4.93333,
            'longitude'    => -52.33334,
            'abbreviation' => 'GFT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Cayman' => [
            'country_code' => 'KY',
            'latitude'     => 19.3,
            'longitude'    => -81.38334,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Chicago' => [
            'country_code' => 'US',
            'latitude'     => 41.85,
            'longitude'    => -87.65,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Chihuahua' => [
            'country_code' => 'MX',
            'latitude'     => 28.63333,
            'longitude'    => -106.08334,
            'abbreviation' => 'MST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Costa_Rica' => [
            'country_code' => 'CR',
            'latitude'     => 9.93333,
            'longitude'    => -84.08334,
            'abbreviation' => 'SJMT',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Creston' => [
            'country_code' => 'CA',
            'latitude'     => 49.1,
            'longitude'    => -116.51667,
            'abbreviation' => 'PST',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Cuiaba' => [
            'country_code' => 'BR',
            'latitude'     => -15.58334,
            'longitude'    => -56.08334,
            'abbreviation' => 'AMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Curacao' => [
            'country_code' => 'CW',
            'latitude'     => 12.18333,
            'longitude'    => -69,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Danmarkshavn' => [
            'country_code' => 'GL',
            'latitude'     => 76.76666,
            'longitude'    => -18.66667,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'America/Dawson' => [
            'country_code' => 'CA',
            'latitude'     => 64.06666,
            'longitude'    => -139.41667,
            'abbreviation' => 'YWT',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Dawson_Creek' => [
            'country_code' => 'CA',
            'latitude'     => 59.76666,
            'longitude'    => -120.23334,
            'abbreviation' => 'PWT',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Denver' => [
            'country_code' => 'US',
            'latitude'     => 39.73916,
            'longitude'    => -104.98417,
            'abbreviation' => 'MWT',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Detroit' => [
            'country_code' => 'US',
            'latitude'     => 42.33138,
            'longitude'    => -83.04584,
            'abbreviation' => 'EWT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Dominica' => [
            'country_code' => 'DM',
            'latitude'     => 15.3,
            'longitude'    => -61.4,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Edmonton' => [
            'country_code' => 'CA',
            'latitude'     => 53.55,
            'longitude'    => -113.46667,
            'abbreviation' => 'MWT',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Eirunepe' => [
            'country_code' => 'BR',
            'latitude'     => -6.66667,
            'longitude'    => -69.86667,
            'abbreviation' => 'AMT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/El_Salvador' => [
            'country_code' => 'SV',
            'latitude'     => 13.7,
            'longitude'    => -89.2,
            'abbreviation' => 'CST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Fort_Nelson' => [
            'country_code' => 'CA',
            'latitude'     => 58.8,
            'longitude'    => -122.7,
            'abbreviation' => 'MST',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Fortaleza' => [
            'country_code' => 'BR',
            'latitude'     => -3.71667,
            'longitude'    => -38.5,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Glace_Bay' => [
            'country_code' => 'CA',
            'latitude'     => 46.19999,
            'longitude'    => -59.95,
            'abbreviation' => 'AWT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Godthab' => [
            'country_code' => 'GL',
            'latitude'     => 64.18333,
            'longitude'    => -51.73334,
            'abbreviation' => 'WGT',
            'offset'       => -7200,
            'gmt_offset'   => -2,
        ],
        'America/Goose_Bay' => [
            'country_code' => 'CA',
            'latitude'     => 53.33333,
            'longitude'    => -60.41667,
            'abbreviation' => 'NWT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Grand_Turk' => [
            'country_code' => 'TC',
            'latitude'     => 21.46666,
            'longitude'    => -71.13334,
            'abbreviation' => 'KMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Grenada' => [
            'country_code' => 'GD',
            'latitude'     => 12.05,
            'longitude'    => -61.75,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Guadeloupe' => [
            'country_code' => 'GP',
            'latitude'     => 16.23333,
            'longitude'    => -61.53334,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Guatemala' => [
            'country_code' => 'GT',
            'latitude'     => 14.63333,
            'longitude'    => -90.51667,
            'abbreviation' => 'CST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Guayaquil' => [
            'country_code' => 'EC',
            'latitude'     => -2.16667,
            'longitude'    => -79.83334,
            'abbreviation' => 'QMT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Guyana' => [
            'country_code' => 'GY',
            'latitude'     => 6.8,
            'longitude'    => -58.16667,
            'abbreviation' => 'GYT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Halifax' => [
            'country_code' => 'CA',
            'latitude'     => 44.65,
            'longitude'    => -63.6,
            'abbreviation' => 'AWT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Havana' => [
            'country_code' => 'CU',
            'latitude'     => 23.13333,
            'longitude'    => -82.36667,
            'abbreviation' => 'HMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Hermosillo' => [
            'country_code' => 'MX',
            'latitude'     => 29.06666,
            'longitude'    => -110.96667,
            'abbreviation' => 'PST',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Indiana/Indianapolis' => [
            'country_code' => 'US',
            'latitude'     => 39.76833,
            'longitude'    => -86.15806,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Indiana/Knox' => [
            'country_code' => 'US',
            'latitude'     => 41.29583,
            'longitude'    => -86.625,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Indiana/Marengo' => [
            'country_code' => 'US',
            'latitude'     => 38.37555,
            'longitude'    => -86.34473,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Indiana/Petersburg' => [
            'country_code' => 'US',
            'latitude'     => 38.49194,
            'longitude'    => -87.27862,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Indiana/Tell_City' => [
            'country_code' => 'US',
            'latitude'     => 37.95305,
            'longitude'    => -86.76139,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Indiana/Vevay' => [
            'country_code' => 'US',
            'latitude'     => 38.74777,
            'longitude'    => -85.06723,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Indiana/Vincennes' => [
            'country_code' => 'US',
            'latitude'     => 38.67722,
            'longitude'    => -87.52862,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Indiana/Winamac' => [
            'country_code' => 'US',
            'latitude'     => 41.05138,
            'longitude'    => -86.60306,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Inuvik' => [
            'country_code' => 'CA',
            'latitude'     => 68.34972,
            'longitude'    => -133.71667,
            'abbreviation' => 'ZZZ',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Iqaluit' => [
            'country_code' => 'CA',
            'latitude'     => 63.73333,
            'longitude'    => -68.46667,
            'abbreviation' => 'ZZZ',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Jamaica' => [
            'country_code' => 'JM',
            'latitude'     => 17.96805,
            'longitude'    => -76.79334,
            'abbreviation' => 'KMT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Juneau' => [
            'country_code' => 'US',
            'latitude'     => 58.30194,
            'longitude'    => -134.41973,
            'abbreviation' => 'YST',
            'offset'       => -28800,
            'gmt_offset'   => -8,
        ],
        'America/Kentucky/Louisville' => [
            'country_code' => 'US',
            'latitude'     => 38.25416,
            'longitude'    => -85.75945,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Kentucky/Monticello' => [
            'country_code' => 'US',
            'latitude'     => 36.82972,
            'longitude'    => -84.84917,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Kralendijk' => [
            'country_code' => 'BQ',
            'latitude'     => 12.15083,
            'longitude'    => -68.27667,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/La_Paz' => [
            'country_code' => 'BO',
            'latitude'     => -16.5,
            'longitude'    => -68.15,
            'abbreviation' => 'CMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Lima' => [
            'country_code' => 'PE',
            'latitude'     => -12.05,
            'longitude'    => -77.05,
            'abbreviation' => 'PET',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Los_Angeles' => [
            'country_code' => 'US',
            'latitude'     => 34.05222,
            'longitude'    => -118.24278,
            'abbreviation' => 'PWT',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Lower_Princes' => [
            'country_code' => 'SX',
            'latitude'     => 18.05138,
            'longitude'    => -63.04723,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Maceio' => [
            'country_code' => 'BR',
            'latitude'     => -9.66667,
            'longitude'    => -35.71667,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Managua' => [
            'country_code' => 'NI',
            'latitude'     => 12.15,
            'longitude'    => -86.28334,
            'abbreviation' => 'MMT',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Manaus' => [
            'country_code' => 'BR',
            'latitude'     => -3.13334,
            'longitude'    => -60.01667,
            'abbreviation' => 'AMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Marigot' => [
            'country_code' => 'MF',
            'latitude'     => 18.06666,
            'longitude'    => -63.08334,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Martinique' => [
            'country_code' => 'MQ',
            'latitude'     => 14.6,
            'longitude'    => -61.08334,
            'abbreviation' => 'FFMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Matamoros' => [
            'country_code' => 'MX',
            'latitude'     => 25.83333,
            'longitude'    => -97.5,
            'abbreviation' => 'CST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Mazatlan' => [
            'country_code' => 'MX',
            'latitude'     => 23.21666,
            'longitude'    => -106.41667,
            'abbreviation' => 'PST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Menominee' => [
            'country_code' => 'US',
            'latitude'     => 45.10777,
            'longitude'    => -87.61417,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Merida' => [
            'country_code' => 'MX',
            'latitude'     => 20.96666,
            'longitude'    => -89.61667,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Metlakatla' => [
            'country_code' => 'US',
            'latitude'     => 55.12694,
            'longitude'    => -131.57639,
            'abbreviation' => 'PWT',
            'offset'       => -28800,
            'gmt_offset'   => -8,
        ],
        'America/Mexico_City' => [
            'country_code' => 'MX',
            'latitude'     => 19.4,
            'longitude'    => -99.15001,
            'abbreviation' => 'MST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Miquelon' => [
            'country_code' => 'PM',
            'latitude'     => 47.05,
            'longitude'    => -56.33334,
            'abbreviation' => 'PMST',
            'offset'       => -7200,
            'gmt_offset'   => -2,
        ],
        'America/Moncton' => [
            'country_code' => 'CA',
            'latitude'     => 46.1,
            'longitude'    => -64.78334,
            'abbreviation' => 'EST',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Monterrey' => [
            'country_code' => 'MX',
            'latitude'     => 25.66666,
            'longitude'    => -100.31667,
            'abbreviation' => 'CST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Montevideo' => [
            'country_code' => 'UY',
            'latitude'     => -34.88334,
            'longitude'    => -56.18334,
            'abbreviation' => 'UYT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Montserrat' => [
            'country_code' => 'MS',
            'latitude'     => 16.71666,
            'longitude'    => -62.21667,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Nassau' => [
            'country_code' => 'BS',
            'latitude'     => 25.08333,
            'longitude'    => -77.35,
            'abbreviation' => 'EST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/New_York' => [
            'country_code' => 'US',
            'latitude'     => 40.71416,
            'longitude'    => -74.00639,
            'abbreviation' => 'EWT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Nipigon' => [
            'country_code' => 'CA',
            'latitude'     => 49.01666,
            'longitude'    => -88.26667,
            'abbreviation' => 'EWT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Nome' => [
            'country_code' => 'US',
            'latitude'     => 64.50111,
            'longitude'    => -165.40639,
            'abbreviation' => 'YST',
            'offset'       => -28800,
            'gmt_offset'   => -8,
        ],
        'America/Noronha' => [
            'country_code' => 'BR',
            'latitude'     => -3.85,
            'longitude'    => -32.41667,
            'abbreviation' => 'FNT',
            'offset'       => -7200,
            'gmt_offset'   => -2,
        ],
        'America/North_Dakota/Beulah' => [
            'country_code' => 'US',
            'latitude'     => 47.26416,
            'longitude'    => -101.77778,
            'abbreviation' => 'MWT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/North_Dakota/Center' => [
            'country_code' => 'US',
            'latitude'     => 47.11638,
            'longitude'    => -101.29917,
            'abbreviation' => 'MWT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/North_Dakota/New_Salem' => [
            'country_code' => 'US',
            'latitude'     => 46.845,
            'longitude'    => -101.41084,
            'abbreviation' => 'MWT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Ojinaga' => [
            'country_code' => 'MX',
            'latitude'     => 29.56666,
            'longitude'    => -104.41667,
            'abbreviation' => 'MST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Panama' => [
            'country_code' => 'PA',
            'latitude'     => 8.96666,
            'longitude'    => -79.53334,
            'abbreviation' => 'EST',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Pangnirtung' => [
            'country_code' => 'CA',
            'latitude'     => 66.13333,
            'longitude'    => -65.73334,
            'abbreviation' => 'ZZZ',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Paramaribo' => [
            'country_code' => 'SR',
            'latitude'     => 5.83333,
            'longitude'    => -55.16667,
            'abbreviation' => 'SRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Phoenix' => [
            'country_code' => 'US',
            'latitude'     => 33.44833,
            'longitude'    => -112.07334,
            'abbreviation' => 'MWT',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Port-au-Prince' => [
            'country_code' => 'HT',
            'latitude'     => 18.53333,
            'longitude'    => -72.33334,
            'abbreviation' => 'PPMT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Port_of_Spain' => [
            'country_code' => 'TT',
            'latitude'     => 10.65,
            'longitude'    => -61.51667,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Porto_Velho' => [
            'country_code' => 'BR',
            'latitude'     => -8.76667,
            'longitude'    => -63.9,
            'abbreviation' => 'AMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Puerto_Rico' => [
            'country_code' => 'PR',
            'latitude'     => 18.46833,
            'longitude'    => -66.10612,
            'abbreviation' => 'AWT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Rainy_River' => [
            'country_code' => 'CA',
            'latitude'     => 48.71666,
            'longitude'    => -94.56667,
            'abbreviation' => 'CWT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Rankin_Inlet' => [
            'country_code' => 'CA',
            'latitude'     => 62.81666,
            'longitude'    => -92.08306,
            'abbreviation' => 'ZZZ',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Recife' => [
            'country_code' => 'BR',
            'latitude'     => -8.05,
            'longitude'    => -34.9,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Regina' => [
            'country_code' => 'CA',
            'latitude'     => 50.4,
            'longitude'    => -104.65001,
            'abbreviation' => 'MWT',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Resolute' => [
            'country_code' => 'CA',
            'latitude'     => 74.69555,
            'longitude'    => -94.82917,
            'abbreviation' => 'ZZZ',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Rio_Branco' => [
            'country_code' => 'BR',
            'latitude'     => -9.96667,
            'longitude'    => -67.8,
            'abbreviation' => 'AMT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Santarem' => [
            'country_code' => 'BR',
            'latitude'     => -2.43334,
            'longitude'    => -54.86667,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Santiago' => [
            'country_code' => 'CL',
            'latitude'     => -33.45,
            'longitude'    => -70.66667,
            'abbreviation' => 'SMT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Santo_Domingo' => [
            'country_code' => 'DO',
            'latitude'     => 18.46666,
            'longitude'    => -69.9,
            'abbreviation' => 'SDMT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Sao_Paulo' => [
            'country_code' => 'BR',
            'latitude'     => -23.53334,
            'longitude'    => -46.61667,
            'abbreviation' => 'BRT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Scoresbysund' => [
            'country_code' => 'GL',
            'latitude'     => 70.48333,
            'longitude'    => -21.96667,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'America/Sitka' => [
            'country_code' => 'US',
            'latitude'     => 57.17638,
            'longitude'    => -135.30195,
            'abbreviation' => 'YST',
            'offset'       => -28800,
            'gmt_offset'   => -8,
        ],
        'America/St_Barthelemy' => [
            'country_code' => 'BL',
            'latitude'     => 17.88333,
            'longitude'    => -62.85,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/St_Johns' => [
            'country_code' => 'CA',
            'latitude'     => 47.56666,
            'longitude'    => -52.71667,
            'abbreviation' => 'NWT',
            'offset'       => -9000,
            'gmt_offset'   => -2.5,
        ],
        'America/St_Kitts' => [
            'country_code' => 'KN',
            'latitude'     => 17.3,
            'longitude'    => -62.71667,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/St_Lucia' => [
            'country_code' => 'LC',
            'latitude'     => 14.01666,
            'longitude'    => -61,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/St_Thomas' => [
            'country_code' => 'VI',
            'latitude'     => 18.35,
            'longitude'    => -64.93334,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/St_Vincent' => [
            'country_code' => 'VC',
            'latitude'     => 13.15,
            'longitude'    => -61.23334,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Swift_Current' => [
            'country_code' => 'CA',
            'latitude'     => 50.28333,
            'longitude'    => -107.83334,
            'abbreviation' => 'MWT',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Tegucigalpa' => [
            'country_code' => 'HN',
            'latitude'     => 14.1,
            'longitude'    => -87.21667,
            'abbreviation' => 'CST',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'America/Thule' => [
            'country_code' => 'GL',
            'latitude'     => 76.56666,
            'longitude'    => -68.78334,
            'abbreviation' => 'AST',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'America/Thunder_Bay' => [
            'country_code' => 'CA',
            'latitude'     => 48.38333,
            'longitude'    => -89.25,
            'abbreviation' => 'EWT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Tijuana' => [
            'country_code' => 'MX',
            'latitude'     => 32.53333,
            'longitude'    => -117.01667,
            'abbreviation' => 'PWT',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Toronto' => [
            'country_code' => 'CA',
            'latitude'     => 43.65,
            'longitude'    => -79.38334,
            'abbreviation' => 'EWT',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Tortola' => [
            'country_code' => 'VG',
            'latitude'     => 18.45,
            'longitude'    => -64.61667,
            'abbreviation' => 'AST',
            'offset'       => -14400,
            'gmt_offset'   => -4,
        ],
        'America/Vancouver' => [
            'country_code' => 'CA',
            'latitude'     => 49.26666,
            'longitude'    => -123.11667,
            'abbreviation' => 'PWT',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Whitehorse' => [
            'country_code' => 'CA',
            'latitude'     => 60.71666,
            'longitude'    => -135.05001,
            'abbreviation' => 'YWT',
            'offset'       => -25200,
            'gmt_offset'   => -7,
        ],
        'America/Winnipeg' => [
            'country_code' => 'CA',
            'latitude'     => 49.88333,
            'longitude'    => -97.15001,
            'abbreviation' => 'CWT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'America/Yakutat' => [
            'country_code' => 'US',
            'latitude'     => 59.54694,
            'longitude'    => -139.72723,
            'abbreviation' => 'YWT',
            'offset'       => -28800,
            'gmt_offset'   => -8,
        ],
        'America/Yellowknife' => [
            'country_code' => 'CA',
            'latitude'     => 62.44999,
            'longitude'    => -114.35,
            'abbreviation' => 'ZZZ',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'Antarctica/Casey' => [
            'country_code' => 'AQ',
            'latitude'     => -66.28334,
            'longitude'    => 110.51666,
            'abbreviation' => 'ZZZ',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Antarctica/Davis' => [
            'country_code' => 'AQ',
            'latitude'     => -68.58334,
            'longitude'    => 77.96666,
            'abbreviation' => 'ZZZ',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Antarctica/DumontDUrville' => [
            'country_code' => 'AQ',
            'latitude'     => -66.66667,
            'longitude'    => 140.01666,
            'abbreviation' => 'ZZZ',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Antarctica/Macquarie' => [
            'country_code' => 'AU',
            'latitude'     => -54.5,
            'longitude'    => 158.95,
            'abbreviation' => 'ZZZ',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Antarctica/Mawson' => [
            'country_code' => 'AQ',
            'latitude'     => -67.6,
            'longitude'    => 62.88333,
            'abbreviation' => 'ZZZ',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Antarctica/McMurdo' => [
            'country_code' => 'AQ',
            'latitude'     => -77.83334,
            'longitude'    => 166.6,
            'abbreviation' => 'NZST',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Antarctica/Palmer' => [
            'country_code' => 'AQ',
            'latitude'     => -64.8,
            'longitude'    => -64.1,
            'abbreviation' => 'ZZZ',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'Antarctica/Rothera' => [
            'country_code' => 'AQ',
            'latitude'     => -67.56667,
            'longitude'    => -68.13334,
            'abbreviation' => 'ZZZ',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'Antarctica/Syowa' => [
            'country_code' => 'AQ',
            'latitude'     => -69.00612,
            'longitude'    => 39.59,
            'abbreviation' => 'ZZZ',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Antarctica/Troll' => [
            'country_code' => 'AQ',
            'latitude'     => -72.01139,
            'longitude'    => 2.535,
            'abbreviation' => 'ZZZ',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Antarctica/Vostok' => [
            'country_code' => 'AQ',
            'latitude'     => -78.40001,
            'longitude'    => 106.89999,
            'abbreviation' => 'ZZZ',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Arctic/Longyearbyen' => [
            'country_code' => 'SJ',
            'latitude'     => 78,
            'longitude'    => 16,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Asia/Aden' => [
            'country_code' => 'YE',
            'latitude'     => 12.75,
            'longitude'    => 45.2,
            'abbreviation' => 'AST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Almaty' => [
            'country_code' => 'KZ',
            'latitude'     => 43.25,
            'longitude'    => 76.95,
            'abbreviation' => 'ALMT',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Amman' => [
            'country_code' => 'JO',
            'latitude'     => 31.95,
            'longitude'    => 35.93333,
            'abbreviation' => 'EET',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Anadyr' => [
            'country_code' => 'RU',
            'latitude'     => 64.75,
            'longitude'    => 177.48333,
            'abbreviation' => 'ANAT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Asia/Aqtau' => [
            'country_code' => 'KZ',
            'latitude'     => 44.51666,
            'longitude'    => 50.26666,
            'abbreviation' => 'SHET',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Aqtobe' => [
            'country_code' => 'KZ',
            'latitude'     => 50.28333,
            'longitude'    => 57.16666,
            'abbreviation' => 'AQTT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Ashgabat' => [
            'country_code' => 'TM',
            'latitude'     => 37.95,
            'longitude'    => 58.38333,
            'abbreviation' => 'TMT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Baghdad' => [
            'country_code' => 'IQ',
            'latitude'     => 33.35,
            'longitude'    => 44.41666,
            'abbreviation' => 'BMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Bahrain' => [
            'country_code' => 'BH',
            'latitude'     => 26.38333,
            'longitude'    => 50.58333,
            'abbreviation' => 'GST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Baku' => [
            'country_code' => 'AZ',
            'latitude'     => 40.38333,
            'longitude'    => 49.85,
            'abbreviation' => 'BAKT',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Asia/Bangkok' => [
            'country_code' => 'TH',
            'latitude'     => 13.75,
            'longitude'    => 100.51666,
            'abbreviation' => 'ICT',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Barnaul' => [
            'country_code' => 'RU',
            'latitude'     => 53.36666,
            'longitude'    => 83.75,
            'abbreviation' => '+07',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Beirut' => [
            'country_code' => 'LB',
            'latitude'     => 33.88333,
            'longitude'    => 35.5,
            'abbreviation' => 'EET',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Bishkek' => [
            'country_code' => 'KG',
            'latitude'     => 42.9,
            'longitude'    => 74.6,
            'abbreviation' => 'KGT',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Brunei' => [
            'country_code' => 'BN',
            'latitude'     => 4.93333,
            'longitude'    => 114.91666,
            'abbreviation' => 'BNT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Chita' => [
            'country_code' => 'RU',
            'latitude'     => 52.05,
            'longitude'    => 113.46666,
            'abbreviation' => 'YAKT',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Choibalsan' => [
            'country_code' => 'MN',
            'latitude'     => 48.06666,
            'longitude'    => 114.5,
            'abbreviation' => 'ULAT',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Colombo' => [
            'country_code' => 'LK',
            'latitude'     => 6.93333,
            'longitude'    => 79.85,
            'abbreviation' => 'MMT',
            'offset'       => 19800,
            'gmt_offset'   => 5.5,
        ],
        'Asia/Damascus' => [
            'country_code' => 'SY',
            'latitude'     => 33.5,
            'longitude'    => 36.3,
            'abbreviation' => 'EET',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Dhaka' => [
            'country_code' => 'BD',
            'latitude'     => 23.71666,
            'longitude'    => 90.41666,
            'abbreviation' => 'IST',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Dili' => [
            'country_code' => 'TL',
            'latitude'     => -8.55,
            'longitude'    => 125.58333,
            'abbreviation' => 'WITA',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Dubai' => [
            'country_code' => 'AE',
            'latitude'     => 25.3,
            'longitude'    => 55.3,
            'abbreviation' => 'GST',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Asia/Dushanbe' => [
            'country_code' => 'TJ',
            'latitude'     => 38.58333,
            'longitude'    => 68.8,
            'abbreviation' => 'TJT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Gaza' => [
            'country_code' => 'PS',
            'latitude'     => 31.5,
            'longitude'    => 34.46666,
            'abbreviation' => 'IST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Hebron' => [
            'country_code' => 'PS',
            'latitude'     => 31.53333,
            'longitude'    => 35.095,
            'abbreviation' => 'IST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Ho_Chi_Minh' => [
            'country_code' => 'VN',
            'latitude'     => 10.75,
            'longitude'    => 106.66666,
            'abbreviation' => 'PLMT',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Hong_Kong' => [
            'country_code' => 'HK',
            'latitude'     => 22.28333,
            'longitude'    => 114.14999,
            'abbreviation' => 'JST',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Hovd' => [
            'country_code' => 'MN',
            'latitude'     => 48.01666,
            'longitude'    => 91.64999,
            'abbreviation' => 'HOVT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Irkutsk' => [
            'country_code' => 'RU',
            'latitude'     => 52.26666,
            'longitude'    => 104.33333,
            'abbreviation' => 'IRKT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Jakarta' => [
            'country_code' => 'ID',
            'latitude'     => -6.16667,
            'longitude'    => 106.8,
            'abbreviation' => 'WIB',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Jayapura' => [
            'country_code' => 'ID',
            'latitude'     => -2.53334,
            'longitude'    => 140.7,
            'abbreviation' => 'WIT',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Jerusalem' => [
            'country_code' => 'IL',
            'latitude'     => 31.78055,
            'longitude'    => 35.22388,
            'abbreviation' => 'JMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Kabul' => [
            'country_code' => 'AF',
            'latitude'     => 34.51666,
            'longitude'    => 69.2,
            'abbreviation' => 'AFT',
            'offset'       => 16200,
            'gmt_offset'   => 4.5,
        ],
        'Asia/Kamchatka' => [
            'country_code' => 'RU',
            'latitude'     => 53.01666,
            'longitude'    => 158.65,
            'abbreviation' => 'PETT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Asia/Karachi' => [
            'country_code' => 'PK',
            'latitude'     => 24.86666,
            'longitude'    => 67.05,
            'abbreviation' => 'PKT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Kathmandu' => [
            'country_code' => 'NP',
            'latitude'     => 27.71666,
            'longitude'    => 85.31666,
            'abbreviation' => 'NPT',
            'offset'       => 20700,
            'gmt_offset'   => 5.75,
        ],
        'Asia/Khandyga' => [
            'country_code' => 'RU',
            'latitude'     => 62.65638,
            'longitude'    => 135.55388,
            'abbreviation' => 'YAKT',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Kolkata' => [
            'country_code' => 'IN',
            'latitude'     => 22.53333,
            'longitude'    => 88.36666,
            'abbreviation' => 'IST',
            'offset'       => 19800,
            'gmt_offset'   => 5.5,
        ],
        'Asia/Krasnoyarsk' => [
            'country_code' => 'RU',
            'latitude'     => 56.01666,
            'longitude'    => 92.83333,
            'abbreviation' => 'KRAT',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Kuala_Lumpur' => [
            'country_code' => 'MY',
            'latitude'     => 3.16666,
            'longitude'    => 101.7,
            'abbreviation' => 'SMT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Kuching' => [
            'country_code' => 'MY',
            'latitude'     => 1.55,
            'longitude'    => 110.33333,
            'abbreviation' => 'MYT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Kuwait' => [
            'country_code' => 'KW',
            'latitude'     => 29.33333,
            'longitude'    => 47.98333,
            'abbreviation' => 'AST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Macau' => [
            'country_code' => 'MO',
            'latitude'     => 22.23333,
            'longitude'    => 113.58333,
            'abbreviation' => 'MOT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Magadan' => [
            'country_code' => 'RU',
            'latitude'     => 59.56666,
            'longitude'    => 150.8,
            'abbreviation' => 'MAGT',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Asia/Makassar' => [
            'country_code' => 'ID',
            'latitude'     => -5.11667,
            'longitude'    => 119.39999,
            'abbreviation' => 'WITA',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Manila' => [
            'country_code' => 'PH',
            'latitude'     => 14.58333,
            'longitude'    => 121,
            'abbreviation' => 'PHT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Muscat' => [
            'country_code' => 'OM',
            'latitude'     => 23.6,
            'longitude'    => 58.58333,
            'abbreviation' => 'GST',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Asia/Nicosia' => [
            'country_code' => 'CY',
            'latitude'     => 35.16666,
            'longitude'    => 33.36666,
            'abbreviation' => 'EET',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Novokuznetsk' => [
            'country_code' => 'RU',
            'latitude'     => 53.75,
            'longitude'    => 87.11666,
            'abbreviation' => 'NOVT',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Novosibirsk' => [
            'country_code' => 'RU',
            'latitude'     => 55.03333,
            'longitude'    => 82.91666,
            'abbreviation' => 'NOVT',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Omsk' => [
            'country_code' => 'RU',
            'latitude'     => 55,
            'longitude'    => 73.4,
            'abbreviation' => 'OMST',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Oral' => [
            'country_code' => 'KZ',
            'latitude'     => 51.21666,
            'longitude'    => 51.35,
            'abbreviation' => 'URAT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Phnom_Penh' => [
            'country_code' => 'KH',
            'latitude'     => 11.55,
            'longitude'    => 104.91666,
            'abbreviation' => 'ICT',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Pontianak' => [
            'country_code' => 'ID',
            'latitude'     => -0.033339999999995,
            'longitude'    => 109.33333,
            'abbreviation' => 'WITA',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Pyongyang' => [
            'country_code' => 'KP',
            'latitude'     => 39.01666,
            'longitude'    => 125.75,
            'abbreviation' => 'KST',
            'offset'       => 30600,
            'gmt_offset'   => 8.5,
        ],
        'Asia/Qatar' => [
            'country_code' => 'QA',
            'latitude'     => 25.28333,
            'longitude'    => 51.53333,
            'abbreviation' => 'GST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Qyzylorda' => [
            'country_code' => 'KZ',
            'latitude'     => 44.8,
            'longitude'    => 65.46666,
            'abbreviation' => 'QYZT',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Rangoon' => [
            'country_code' => 'MM',
            'latitude'     => 16.78333,
            'longitude'    => 96.16666,
            'abbreviation' => 'RMT',
            'offset'       => 23400,
            'gmt_offset'   => 6.5,
        ],
        'Asia/Riyadh' => [
            'country_code' => 'SA',
            'latitude'     => 24.63333,
            'longitude'    => 46.71666,
            'abbreviation' => 'AST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Asia/Sakhalin' => [
            'country_code' => 'RU',
            'latitude'     => 46.96666,
            'longitude'    => 142.7,
            'abbreviation' => 'SAKT',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Asia/Samarkand' => [
            'country_code' => 'UZ',
            'latitude'     => 39.66666,
            'longitude'    => 66.8,
            'abbreviation' => 'UZT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Seoul' => [
            'country_code' => 'KR',
            'latitude'     => 37.55,
            'longitude'    => 126.96666,
            'abbreviation' => 'KST',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Shanghai' => [
            'country_code' => 'CN',
            'latitude'     => 31.23333,
            'longitude'    => 121.46666,
            'abbreviation' => 'CST',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Singapore' => [
            'country_code' => 'SG',
            'latitude'     => 1.28333,
            'longitude'    => 103.85,
            'abbreviation' => 'SMT',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Srednekolymsk' => [
            'country_code' => 'RU',
            'latitude'     => 67.46666,
            'longitude'    => 153.71666,
            'abbreviation' => 'SRET',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Asia/Taipei' => [
            'country_code' => 'TW',
            'latitude'     => 25.05,
            'longitude'    => 121.5,
            'abbreviation' => 'JWST',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Asia/Tashkent' => [
            'country_code' => 'UZ',
            'latitude'     => 41.33333,
            'longitude'    => 69.3,
            'abbreviation' => 'UZT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Tbilisi' => [
            'country_code' => 'GE',
            'latitude'     => 41.71666,
            'longitude'    => 44.81666,
            'abbreviation' => 'TBMT',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Asia/Tehran' => [
            'country_code' => 'IR',
            'latitude'     => 35.66666,
            'longitude'    => 51.43333,
            'abbreviation' => 'TMT',
            'offset'       => 16200,
            'gmt_offset'   => 4.5,
        ],
        'Asia/Thimphu' => [
            'country_code' => 'BT',
            'latitude'     => 27.46666,
            'longitude'    => 89.64999,
            'abbreviation' => 'IST',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Tokyo' => [
            'country_code' => 'JP',
            'latitude'     => 35.65444,
            'longitude'    => 139.74472,
            'abbreviation' => 'JST',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Ulaanbaatar' => [
            'country_code' => 'MN',
            'latitude'     => 47.91666,
            'longitude'    => 106.88333,
            'abbreviation' => 'ULAT',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Urumqi' => [
            'country_code' => 'CN',
            'latitude'     => 43.8,
            'longitude'    => 87.58333,
            'abbreviation' => 'XJT',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Asia/Ust-Nera' => [
            'country_code' => 'RU',
            'latitude'     => 64.56027,
            'longitude'    => 143.22666,
            'abbreviation' => 'YAKT',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Asia/Vientiane' => [
            'country_code' => 'LA',
            'latitude'     => 17.96666,
            'longitude'    => 102.6,
            'abbreviation' => 'ICT',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Asia/Vladivostok' => [
            'country_code' => 'RU',
            'latitude'     => 43.16666,
            'longitude'    => 131.93333,
            'abbreviation' => 'VLAT',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Asia/Yakutsk' => [
            'country_code' => 'RU',
            'latitude'     => 62,
            'longitude'    => 129.66666,
            'abbreviation' => 'YAKT',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Asia/Yekaterinburg' => [
            'country_code' => 'RU',
            'latitude'     => 56.85,
            'longitude'    => 60.6,
            'abbreviation' => 'YEKT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Asia/Yerevan' => [
            'country_code' => 'AM',
            'latitude'     => 40.18333,
            'longitude'    => 44.5,
            'abbreviation' => 'YERT',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Atlantic/Azores' => [
            'country_code' => 'PT',
            'latitude'     => 37.73333,
            'longitude'    => -25.66667,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Atlantic/Bermuda' => [
            'country_code' => 'BM',
            'latitude'     => 32.28333,
            'longitude'    => -64.76667,
            'abbreviation' => 'AST',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'Atlantic/Canary' => [
            'country_code' => 'ES',
            'latitude'     => 28.1,
            'longitude'    => -15.4,
            'abbreviation' => 'WET',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Atlantic/Cape_Verde' => [
            'country_code' => 'CV',
            'latitude'     => 14.91666,
            'longitude'    => -23.51667,
            'abbreviation' => 'CVT',
            'offset'       => -3600,
            'gmt_offset'   => -1,
        ],
        'Atlantic/Faroe' => [
            'country_code' => 'FO',
            'latitude'     => 62.01666,
            'longitude'    => -6.76667,
            'abbreviation' => 'WET',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Atlantic/Madeira' => [
            'country_code' => 'PT',
            'latitude'     => 32.63333,
            'longitude'    => -16.9,
            'abbreviation' => 'WET',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Atlantic/Reykjavik' => [
            'country_code' => 'IS',
            'latitude'     => 64.15,
            'longitude'    => -21.85,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Atlantic/South_Georgia' => [
            'country_code' => 'GS',
            'latitude'     => -54.26667,
            'longitude'    => -36.53334,
            'abbreviation' => 'GST',
            'offset'       => -7200,
            'gmt_offset'   => -2,
        ],
        'Atlantic/St_Helena' => [
            'country_code' => 'SH',
            'latitude'     => -15.91667,
            'longitude'    => -5.7,
            'abbreviation' => 'UTC',
            'offset'       => 0,
            'gmt_offset'   => 0,
        ],
        'Atlantic/Stanley' => [
            'country_code' => 'FK',
            'latitude'     => -51.70001,
            'longitude'    => -57.85,
            'abbreviation' => 'SMT',
            'offset'       => -10800,
            'gmt_offset'   => -3,
        ],
        'Australia/Adelaide' => [
            'country_code' => 'AU',
            'latitude'     => -34.91667,
            'longitude'    => 138.58333,
            'abbreviation' => 'CAST',
            'offset'       => 34200,
            'gmt_offset'   => 9.5,
        ],
        'Australia/Brisbane' => [
            'country_code' => 'AU',
            'latitude'     => -27.46667,
            'longitude'    => 153.03333,
            'abbreviation' => 'AEST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Australia/Broken_Hill' => [
            'country_code' => 'AU',
            'latitude'     => -31.95,
            'longitude'    => 141.45,
            'abbreviation' => 'ACST',
            'offset'       => 34200,
            'gmt_offset'   => 9.5,
        ],
        'Australia/Currie' => [
            'country_code' => 'AU',
            'latitude'     => -39.93334,
            'longitude'    => 143.86666,
            'abbreviation' => 'AEST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Australia/Darwin' => [
            'country_code' => 'AU',
            'latitude'     => -12.46667,
            'longitude'    => 130.83333,
            'abbreviation' => 'ACST',
            'offset'       => 34200,
            'gmt_offset'   => 9.5,
        ],
        'Australia/Eucla' => [
            'country_code' => 'AU',
            'latitude'     => -31.71667,
            'longitude'    => 128.86666,
            'abbreviation' => 'ACWST',
            'offset'       => 31500,
            'gmt_offset'   => 8.75,
        ],
        'Australia/Hobart' => [
            'country_code' => 'AU',
            'latitude'     => -42.88334,
            'longitude'    => 147.31666,
            'abbreviation' => 'AEST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Australia/Lindeman' => [
            'country_code' => 'AU',
            'latitude'     => -20.26667,
            'longitude'    => 149,
            'abbreviation' => 'AEST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Australia/Lord_Howe' => [
            'country_code' => 'AU',
            'latitude'     => -31.55,
            'longitude'    => 159.08333,
            'abbreviation' => 'LHST',
            'offset'       => 37800,
            'gmt_offset'   => 10.5,
        ],
        'Australia/Melbourne' => [
            'country_code' => 'AU',
            'latitude'     => -37.81667,
            'longitude'    => 144.96666,
            'abbreviation' => 'AEST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Australia/Perth' => [
            'country_code' => 'AU',
            'latitude'     => -31.95,
            'longitude'    => 115.85,
            'abbreviation' => 'AWST',
            'offset'       => 28800,
            'gmt_offset'   => 8,
        ],
        'Australia/Sydney' => [
            'country_code' => 'AU',
            'latitude'     => -33.86667,
            'longitude'    => 151.21666,
            'abbreviation' => 'AEST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Europe/Amsterdam' => [
            'country_code' => 'NL',
            'latitude'     => 52.36666,
            'longitude'    => 4.9,
            'abbreviation' => 'NST',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Andorra' => [
            'country_code' => 'AD',
            'latitude'     => 42.5,
            'longitude'    => 1.51666,
            'abbreviation' => 'WET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Astrakhan' => [
            'country_code' => 'RU',
            'latitude'     => 46.35,
            'longitude'    => 48.05,
            'abbreviation' => '+04',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Europe/Athens' => [
            'country_code' => 'GR',
            'latitude'     => 37.96666,
            'longitude'    => 23.71666,
            'abbreviation' => 'EET',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Belgrade' => [
            'country_code' => 'RS',
            'latitude'     => 44.83333,
            'longitude'    => 20.5,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Berlin' => [
            'country_code' => 'DE',
            'latitude'     => 52.5,
            'longitude'    => 13.36666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Bratislava' => [
            'country_code' => 'SK',
            'latitude'     => 48.15,
            'longitude'    => 17.11666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Brussels' => [
            'country_code' => 'BE',
            'latitude'     => 50.83333,
            'longitude'    => 4.33333,
            'abbreviation' => 'WET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Bucharest' => [
            'country_code' => 'RO',
            'latitude'     => 44.43333,
            'longitude'    => 26.1,
            'abbreviation' => 'EET',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Budapest' => [
            'country_code' => 'HU',
            'latitude'     => 47.5,
            'longitude'    => 19.08333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Busingen' => [
            'country_code' => 'DE',
            'latitude'     => 47.69999,
            'longitude'    => 8.68333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Chisinau' => [
            'country_code' => 'MD',
            'latitude'     => 47,
            'longitude'    => 28.83333,
            'abbreviation' => 'MSK',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Copenhagen' => [
            'country_code' => 'DK',
            'latitude'     => 55.66666,
            'longitude'    => 12.58333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Dublin' => [
            'country_code' => 'IE',
            'latitude'     => 53.33333,
            'longitude'    => -6.25,
            'abbreviation' => 'IST',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Europe/Gibraltar' => [
            'country_code' => 'GI',
            'latitude'     => 36.13333,
            'longitude'    => -5.35,
            'abbreviation' => 'GMT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Guernsey' => [
            'country_code' => 'GG',
            'latitude'     => 49.44999,
            'longitude'    => -2.53334,
            'abbreviation' => 'GMT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Europe/Helsinki' => [
            'country_code' => 'FI',
            'latitude'     => 60.16666,
            'longitude'    => 24.96666,
            'abbreviation' => 'HMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Isle_of_Man' => [
            'country_code' => 'IM',
            'latitude'     => 54.15,
            'longitude'    => -4.46667,
            'abbreviation' => 'GMT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Europe/Istanbul' => [
            'country_code' => 'TR',
            'latitude'     => 41.01666,
            'longitude'    => 28.96666,
            'abbreviation' => 'TRT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Jersey' => [
            'country_code' => 'JE',
            'latitude'     => 49.19999,
            'longitude'    => -2.11667,
            'abbreviation' => 'GMT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Europe/Kaliningrad' => [
            'country_code' => 'RU',
            'latitude'     => 54.71666,
            'longitude'    => 20.5,
            'abbreviation' => 'MSK',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Kiev' => [
            'country_code' => 'UA',
            'latitude'     => 50.43333,
            'longitude'    => 30.51666,
            'abbreviation' => 'MSK',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Lisbon' => [
            'country_code' => 'PT',
            'latitude'     => 38.71666,
            'longitude'    => -9.13334,
            'abbreviation' => 'WET',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Europe/Ljubljana' => [
            'country_code' => 'SI',
            'latitude'     => 46.05,
            'longitude'    => 14.51666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/London' => [
            'country_code' => 'GB',
            'latitude'     => 51.50833,
            'longitude'    => -0.12528,
            'abbreviation' => 'GMT',
            'offset'       => 3600,
            'gmt_offset'   => 1,
        ],
        'Europe/Luxembourg' => [
            'country_code' => 'LU',
            'latitude'     => 49.6,
            'longitude'    => 6.15,
            'abbreviation' => 'WET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Madrid' => [
            'country_code' => 'ES',
            'latitude'     => 40.4,
            'longitude'    => -3.68334,
            'abbreviation' => 'WET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Malta' => [
            'country_code' => 'MT',
            'latitude'     => 35.9,
            'longitude'    => 14.51666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Mariehamn' => [
            'country_code' => 'AX',
            'latitude'     => 60.1,
            'longitude'    => 19.95,
            'abbreviation' => 'HMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Minsk' => [
            'country_code' => 'BY',
            'latitude'     => 53.9,
            'longitude'    => 27.56666,
            'abbreviation' => 'MSK',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Monaco' => [
            'country_code' => 'MC',
            'latitude'     => 43.69999,
            'longitude'    => 7.38333,
            'abbreviation' => 'WET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Moscow' => [
            'country_code' => 'RU',
            'latitude'     => 55.75583,
            'longitude'    => 37.61777,
            'abbreviation' => 'MST',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Oslo' => [
            'country_code' => 'NO',
            'latitude'     => 59.91666,
            'longitude'    => 10.75,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Paris' => [
            'country_code' => 'FR',
            'latitude'     => 48.86666,
            'longitude'    => 2.33333,
            'abbreviation' => 'WET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Podgorica' => [
            'country_code' => 'ME',
            'latitude'     => 42.43333,
            'longitude'    => 19.26666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Prague' => [
            'country_code' => 'CZ',
            'latitude'     => 50.08333,
            'longitude'    => 14.43333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Riga' => [
            'country_code' => 'LV',
            'latitude'     => 56.94999,
            'longitude'    => 24.1,
            'abbreviation' => 'RMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Rome' => [
            'country_code' => 'IT',
            'latitude'     => 41.9,
            'longitude'    => 12.48333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Samara' => [
            'country_code' => 'RU',
            'latitude'     => 53.19999,
            'longitude'    => 50.15,
            'abbreviation' => 'SAMT',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Europe/San_Marino' => [
            'country_code' => 'SM',
            'latitude'     => 43.91666,
            'longitude'    => 12.46666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Sarajevo' => [
            'country_code' => 'BA',
            'latitude'     => 43.86666,
            'longitude'    => 18.41666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Simferopol' => [
            'country_code' => 'RU',
            'latitude'     => 44.94999,
            'longitude'    => 34.1,
            'abbreviation' => 'SMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Skopje' => [
            'country_code' => 'MK',
            'latitude'     => 41.98333,
            'longitude'    => 21.43333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Sofia' => [
            'country_code' => 'BG',
            'latitude'     => 42.68333,
            'longitude'    => 23.31666,
            'abbreviation' => 'EET',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Stockholm' => [
            'country_code' => 'SE',
            'latitude'     => 59.33333,
            'longitude'    => 18.05,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Tallinn' => [
            'country_code' => 'EE',
            'latitude'     => 59.41666,
            'longitude'    => 24.75,
            'abbreviation' => 'TMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Tirane' => [
            'country_code' => 'AL',
            'latitude'     => 41.33333,
            'longitude'    => 19.83333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Ulyanovsk' => [
            'country_code' => 'RU',
            'latitude'     => 54.33333,
            'longitude'    => 48.4,
            'abbreviation' => '+04',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Europe/Uzhgorod' => [
            'country_code' => 'UA',
            'latitude'     => 48.61666,
            'longitude'    => 22.3,
            'abbreviation' => 'MSK',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Vaduz' => [
            'country_code' => 'LI',
            'latitude'     => 47.15,
            'longitude'    => 9.51666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Vatican' => [
            'country_code' => 'VA',
            'latitude'     => 41.90222,
            'longitude'    => 12.45305,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Vienna' => [
            'country_code' => 'AT',
            'latitude'     => 48.21666,
            'longitude'    => 16.33333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Vilnius' => [
            'country_code' => 'LT',
            'latitude'     => 54.68333,
            'longitude'    => 25.31666,
            'abbreviation' => 'WMT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Volgograd' => [
            'country_code' => 'RU',
            'latitude'     => 48.73333,
            'longitude'    => 44.41666,
            'abbreviation' => 'VOLT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Warsaw' => [
            'country_code' => 'PL',
            'latitude'     => 52.25,
            'longitude'    => 21,
            'abbreviation' => 'WMT',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Zagreb' => [
            'country_code' => 'HR',
            'latitude'     => 45.8,
            'longitude'    => 15.96666,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Europe/Zaporozhye' => [
            'country_code' => 'UA',
            'latitude'     => 47.83333,
            'longitude'    => 35.16666,
            'abbreviation' => 'MSK',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Europe/Zurich' => [
            'country_code' => 'CH',
            'latitude'     => 47.38333,
            'longitude'    => 8.53333,
            'abbreviation' => 'CET',
            'offset'       => 7200,
            'gmt_offset'   => 2,
        ],
        'Indian/Antananarivo' => [
            'country_code' => 'MG',
            'latitude'     => -18.91667,
            'longitude'    => 47.51666,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Indian/Chagos' => [
            'country_code' => 'IO',
            'latitude'     => -7.33334,
            'longitude'    => 72.41666,
            'abbreviation' => 'IOT',
            'offset'       => 21600,
            'gmt_offset'   => 6,
        ],
        'Indian/Christmas' => [
            'country_code' => 'CX',
            'latitude'     => -10.41667,
            'longitude'    => 105.71666,
            'abbreviation' => 'CXT',
            'offset'       => 25200,
            'gmt_offset'   => 7,
        ],
        'Indian/Cocos' => [
            'country_code' => 'CC',
            'latitude'     => -12.16667,
            'longitude'    => 96.91666,
            'abbreviation' => 'CCT',
            'offset'       => 23400,
            'gmt_offset'   => 6.5,
        ],
        'Indian/Comoro' => [
            'country_code' => 'KM',
            'latitude'     => -11.68334,
            'longitude'    => 43.26666,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Indian/Kerguelen' => [
            'country_code' => 'TF',
            'latitude'     => -49.35278,
            'longitude'    => 70.2175,
            'abbreviation' => 'ZZZ',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Indian/Mahe' => [
            'country_code' => 'SC',
            'latitude'     => -4.66667,
            'longitude'    => 55.46666,
            'abbreviation' => 'SCT',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Indian/Maldives' => [
            'country_code' => 'MV',
            'latitude'     => 4.16666,
            'longitude'    => 73.5,
            'abbreviation' => 'MVT',
            'offset'       => 18000,
            'gmt_offset'   => 5,
        ],
        'Indian/Mauritius' => [
            'country_code' => 'MU',
            'latitude'     => -20.16667,
            'longitude'    => 57.5,
            'abbreviation' => 'MUT',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Indian/Mayotte' => [
            'country_code' => 'YT',
            'latitude'     => -12.78334,
            'longitude'    => 45.23333,
            'abbreviation' => 'EAT',
            'offset'       => 10800,
            'gmt_offset'   => 3,
        ],
        'Indian/Reunion' => [
            'country_code' => 'RE',
            'latitude'     => -20.86667,
            'longitude'    => 55.46666,
            'abbreviation' => 'RET',
            'offset'       => 14400,
            'gmt_offset'   => 4,
        ],
        'Pacific/Apia' => [
            'country_code' => 'WS',
            'latitude'     => -13.83334,
            'longitude'    => -171.73334,
            'abbreviation' => 'WSST',
            'offset'       => 46800,
            'gmt_offset'   => 13,
        ],
        'Pacific/Auckland' => [
            'country_code' => 'NZ',
            'latitude'     => -36.86667,
            'longitude'    => 174.76666,
            'abbreviation' => 'NZST',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Bougainville' => [
            'country_code' => 'PG',
            'latitude'     => -6.21667,
            'longitude'    => 155.56666,
            'abbreviation' => 'PGT',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Pacific/Chatham' => [
            'country_code' => 'NZ',
            'latitude'     => -43.95,
            'longitude'    => -176.55001,
            'abbreviation' => 'CHAST',
            'offset'       => 45900,
            'gmt_offset'   => 12.75,
        ],
        'Pacific/Chuuk' => [
            'country_code' => 'FM',
            'latitude'     => 7.41666,
            'longitude'    => 151.78333,
            'abbreviation' => 'CHUT',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Pacific/Easter' => [
            'country_code' => 'CL',
            'latitude'     => -27.15,
            'longitude'    => -109.43334,
            'abbreviation' => 'EMT',
            'offset'       => -18000,
            'gmt_offset'   => -5,
        ],
        'Pacific/Efate' => [
            'country_code' => 'VU',
            'latitude'     => -17.66667,
            'longitude'    => 168.41666,
            'abbreviation' => 'VUT',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Pacific/Enderbury' => [
            'country_code' => 'KI',
            'latitude'     => -3.13334,
            'longitude'    => -171.08334,
            'abbreviation' => 'PHOT',
            'offset'       => 46800,
            'gmt_offset'   => 13,
        ],
        'Pacific/Fakaofo' => [
            'country_code' => 'TK',
            'latitude'     => -9.36667,
            'longitude'    => -171.23334,
            'abbreviation' => 'TKT',
            'offset'       => 46800,
            'gmt_offset'   => 13,
        ],
        'Pacific/Fiji' => [
            'country_code' => 'FJ',
            'latitude'     => -18.13334,
            'longitude'    => 178.41666,
            'abbreviation' => 'FJT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Funafuti' => [
            'country_code' => 'TV',
            'latitude'     => -8.51667,
            'longitude'    => 179.21666,
            'abbreviation' => 'TVT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Galapagos' => [
            'country_code' => 'EC',
            'latitude'     => -0.90000000000001,
            'longitude'    => -89.6,
            'abbreviation' => 'GALT',
            'offset'       => -21600,
            'gmt_offset'   => -6,
        ],
        'Pacific/Gambier' => [
            'country_code' => 'PF',
            'latitude'     => -23.13334,
            'longitude'    => -134.95,
            'abbreviation' => 'GAMT',
            'offset'       => -32400,
            'gmt_offset'   => -9,
        ],
        'Pacific/Guadalcanal' => [
            'country_code' => 'SB',
            'latitude'     => -9.53334,
            'longitude'    => 160.2,
            'abbreviation' => 'SBT',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Pacific/Guam' => [
            'country_code' => 'GU',
            'latitude'     => 13.46666,
            'longitude'    => 144.75,
            'abbreviation' => 'GST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Pacific/Honolulu' => [
            'country_code' => 'US',
            'latitude'     => 21.30694,
            'longitude'    => -157.85834,
            'abbreviation' => 'HST',
            'offset'       => -36000,
            'gmt_offset'   => -10,
        ],
        'Pacific/Johnston' => [
            'country_code' => 'UM',
            'latitude'     => 16.75,
            'longitude'    => -169.51667,
            'abbreviation' => 'HST',
            'offset'       => -36000,
            'gmt_offset'   => -10,
        ],
        'Pacific/Kiritimati' => [
            'country_code' => 'KI',
            'latitude'     => 1.86666,
            'longitude'    => -157.33334,
            'abbreviation' => 'LINT',
            'offset'       => 50400,
            'gmt_offset'   => 14,
        ],
        'Pacific/Kosrae' => [
            'country_code' => 'FM',
            'latitude'     => 5.31666,
            'longitude'    => 162.98333,
            'abbreviation' => 'KOST',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Pacific/Kwajalein' => [
            'country_code' => 'MH',
            'latitude'     => 9.08333,
            'longitude'    => 167.33333,
            'abbreviation' => 'MHT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Majuro' => [
            'country_code' => 'MH',
            'latitude'     => 7.15,
            'longitude'    => 171.2,
            'abbreviation' => 'MHT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Marquesas' => [
            'country_code' => 'PF',
            'latitude'     => -9,
            'longitude'    => -139.5,
            'abbreviation' => 'MART',
            'offset'       => -34200,
            'gmt_offset'   => -9.5,
        ],
        'Pacific/Midway' => [
            'country_code' => 'UM',
            'latitude'     => 28.21666,
            'longitude'    => -177.36667,
            'abbreviation' => 'SST',
            'offset'       => -39600,
            'gmt_offset'   => -11,
        ],
        'Pacific/Nauru' => [
            'country_code' => 'NR',
            'latitude'     => -0.51667,
            'longitude'    => 166.91666,
            'abbreviation' => 'NRT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Niue' => [
            'country_code' => 'NU',
            'latitude'     => -19.01667,
            'longitude'    => -169.91667,
            'abbreviation' => 'NUT',
            'offset'       => -39600,
            'gmt_offset'   => -11,
        ],
        'Pacific/Norfolk' => [
            'country_code' => 'NF',
            'latitude'     => -29.05,
            'longitude'    => 167.96666,
            'abbreviation' => 'NMT',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Pacific/Noumea' => [
            'country_code' => 'NC',
            'latitude'     => -22.26667,
            'longitude'    => 166.45,
            'abbreviation' => 'NCT',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Pacific/Pago_Pago' => [
            'country_code' => 'AS',
            'latitude'     => -14.26667,
            'longitude'    => -170.7,
            'abbreviation' => 'SST',
            'offset'       => -39600,
            'gmt_offset'   => -11,
        ],
        'Pacific/Palau' => [
            'country_code' => 'PW',
            'latitude'     => 7.33333,
            'longitude'    => 134.48333,
            'abbreviation' => 'PWT',
            'offset'       => 32400,
            'gmt_offset'   => 9,
        ],
        'Pacific/Pitcairn' => [
            'country_code' => 'PN',
            'latitude'     => -25.06667,
            'longitude'    => -130.08334,
            'abbreviation' => 'PST',
            'offset'       => -28800,
            'gmt_offset'   => -8,
        ],
        'Pacific/Pohnpei' => [
            'country_code' => 'FM',
            'latitude'     => 6.96666,
            'longitude'    => 158.21666,
            'abbreviation' => 'PONT',
            'offset'       => 39600,
            'gmt_offset'   => 11,
        ],
        'Pacific/Port_Moresby' => [
            'country_code' => 'PG',
            'latitude'     => -9.5,
            'longitude'    => 147.16666,
            'abbreviation' => 'PGT',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Pacific/Rarotonga' => [
            'country_code' => 'CK',
            'latitude'     => -21.23334,
            'longitude'    => -159.76667,
            'abbreviation' => 'CKT',
            'offset'       => -36000,
            'gmt_offset'   => -10,
        ],
        'Pacific/Saipan' => [
            'country_code' => 'MP',
            'latitude'     => 15.2,
            'longitude'    => 145.75,
            'abbreviation' => 'GST',
            'offset'       => 36000,
            'gmt_offset'   => 10,
        ],
        'Pacific/Tahiti' => [
            'country_code' => 'PF',
            'latitude'     => -17.53334,
            'longitude'    => -149.56667,
            'abbreviation' => 'TAHT',
            'offset'       => -36000,
            'gmt_offset'   => -10,
        ],
        'Pacific/Tarawa' => [
            'country_code' => 'KI',
            'latitude'     => 1.41666,
            'longitude'    => 173,
            'abbreviation' => 'GILT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Tongatapu' => [
            'country_code' => 'TO',
            'latitude'     => -21.16667,
            'longitude'    => -175.16667,
            'abbreviation' => 'TOT',
            'offset'       => 46800,
            'gmt_offset'   => 13,
        ],
        'Pacific/Wake' => [
            'country_code' => 'UM',
            'latitude'     => 19.28333,
            'longitude'    => 166.61666,
            'abbreviation' => 'WAKT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
        'Pacific/Wallis' => [
            'country_code' => 'WF',
            'latitude'     => -13.3,
            'longitude'    => -176.16667,
            'abbreviation' => 'WFT',
            'offset'       => 43200,
            'gmt_offset'   => 12,
        ],
    ];

    /**
     * Getting Data
     *
     * @return array
     */
    public function getAll()
    {
        $ret_val = [];
        foreach ($this->time_zone_list as $key => $v) {
            $v[self::ZONE_NAME] = $key;
            $ret_val[$key] = $v;
        }

        return $ret_val;
    }

    /**
     * List by
     *
     * @param string $listBy
     *
     * @return \Generator
     * @throws \InvalidArgumentException
     */
    public function generatorListBy($listBy = self::ZONE_NAME)
    {
        if (!is_string($listBy)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid parameter list by. Value must be as string  %s given.',
                    gettype($listBy)
                ),
                E_USER_ERROR
            );
        }

        $listBy = trim(strtolower($listBy));
        if (!in_array($listBy, $keys = [
            self::ZONE_NAME,
            self::ABBREVIATION,
            self::COUNTRY_CODE,
            self::LATITUDE,
            self::LONGITUDE,
            self::GMT_OFFSET,
            self::OFFSET,
        ], true)) {
            throw new \DomainException(sprintf(
                'Invalid value for index, got "%s", expected one of: %s',
                (string) $listBy,
                implode(', ', $keys)
            ));
        }
        if ($listBy == self::ZONE_NAME) {
            foreach ($this->time_zone_list as $key => $zone) {
                $zone[self::ZONE_NAME] = $key;
                yield $key => $zone;
            }
        } else {
            foreach ($this->time_zone_list as $key => $zone) {
                $zone[self::ZONE_NAME] = $key;
                yield $zone[$listBy] => $zone;
            }
        }
    }

    /**
     * Generator List By Offset
     *
     * @return \Generator
     */
    public function generatorListByOffset()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $zone[self::OFFSET] => $zone;
        }
    }

    /**
     * @param string|int $id
     * @return array|null
     */
    public function getByOffset($id)
    {
        if (!is_numeric($id)) {
            return null;
        }

        $ret_val = null;
        foreach ($this as $key => $v) {
            if (!($v[self::OFFSET] <> $id)) {
                ! isset($ret_val) && $ret_val = [];
                $ret_val[$key] = $v;
            }
        }

        return $ret_val;
    }

    /**
     * Generator Get By GMT Offset
     *
     * @return \Generator
     */
    public function generatorListByGMTOffset()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $zone[self::GMT_OFFSET] => $zone;
        }
    }

    /**
     * @param string|int $id
     * @return array|null
     */
    public function getByGMTOffset($id)
    {
        if (!is_numeric($id)) {
            return null;
        }

        $ret_val = null;
        foreach ($this as $key => $v) {
            if (!($v[self::GMT_OFFSET] <> $id)) {
                ! isset($ret_val) && $ret_val = [];
                $ret_val[$key] = $v;
            }
        }

        return $ret_val;
    }

    /**
     * Generator get By ZONE NAME
     *
     * @return \Generator
     */
    public function generatorListByZoneName()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $key => $zone;
        }
    }

    /**
     * Generator get By ZONE NAME
     *
     * @return \Generator
     */
    public function generatorListByZone()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $key => $zone;
        }
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getByZoneName($id)
    {
        if (!is_string($id) || ! strpos($id, '/')) {
            return null;
        }
        $id = explode('/', $id);
        $id = array_map(function ($id) {
            if (strpos($id, '_')) {
                $id = explode('_', $id);
                $id = array_map('ucfirst', $id);
                $id = implode('_', $id);
            }
            return ucfirst($id);
        }, array_map('trim', $id));
        $id = implode('/', $id);
        return isset($this->time_zone_list[$id]) ? [$id => $this->time_zone_list[$id]] : null;
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getByZone($id)
    {
        return $this->getByZoneName($id);
    }

    /**
     * Generator Get By Latitude
     *
     * @return \Generator
     */
    public function generatorListByLatitude()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $zone[self::LATITUDE] => $zone;
        }
    }

    /**
     * @param string|int $id
     * @return array|null
     */
    public function getByLatitude($id)
    {
        if (!is_numeric($id)) {
            return null;
        }
        $ret_val = null;
        foreach ($this as $key => $v) {
            if (!($v[self::LATITUDE] <> $id)) {
                ! isset($ret_val) && $ret_val = [];
                $ret_val[$key] = $v;
            }
        }

        return $ret_val;
    }

    /**
     * Generator Get By Longitude

     * @return \Generator
     */
    public function generatorListByLongitude()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $zone[self::LONGITUDE] => $zone;
        }
    }

    /**
     * @param string|int $id
     * @return array|null
     */
    public function getByLongitude($id)
    {
        if (!is_numeric($id)) {
            return null;
        }
        $ret_val = null;
        foreach ($this as $key => $v) {
            if (!($v[self::LONGITUDE] <> $id)) {
                ! isset($ret_val) && $ret_val = [];
                $ret_val[$key] = $v;
            }
        }

        return $ret_val;
    }

    /**
     * Generator Get By Abbreviation
     *
     * @return \Generator
     */
    public function generatorListByAbbreviation()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $zone[self::ABBREVIATION] => $zone;
        }
    }

    /**
     * Generator Get By Abbreviation
     *
     * @return \Generator
     */
    public function generatorListByAbbr()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $zone[self::ABBREVIATION] => $zone;
        }
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getByAbbreviation($id)
    {
        if (!is_string($id)) {
            return null;
        }
        $id = trim(strtoupper($id));
        $ret_val = null;
        foreach ($this as $key => $v) {
            if ($v[self::ABBREVIATION] == $id) {
                ! isset($ret_val) && $ret_val = [];
                $ret_val[$key] = $v;
                break;
            }
        }

        return $ret_val;
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getByAbbr($id)
    {
        return $this->getByAbbreviation($id);
    }

    /**
     * Generator Get By Country Code
     *
     * @return \Generator
     */
    public function generatorListByCountryCode()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $zone[self::COUNTRY_CODE] => $zone;
        }
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getByCountryCode($id)
    {
        if (!is_string($id)) {
            return null;
        }
        $id = trim(strtoupper($id));
        $ret_val = null;
        foreach ($this as $key => $v) {
            if ($v[self::COUNTRY_CODE] == $id) {
                ! isset($ret_val) && $ret_val = [];
                $ret_val[$key] = $v;
            }
        }

        return $ret_val;
    }

    /**
     * @internal
     *
     * @return \Generator
     */
    public function getIterator()
    {
        foreach ($this->time_zone_list as $key => $zone) {
            $zone[self::ZONE_NAME] = $key;
            yield $key => $zone;
        }
    }
}

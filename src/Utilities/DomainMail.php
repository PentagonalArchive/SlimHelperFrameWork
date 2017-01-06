<?php
namespace Pentagonal\SlimHelper\Utilities;

use Pentagonal\SlimHelper\Http\Transporter\Transport;
use Pentagonal\SlimHelper\Record\Arrays\Collection;

/**
 * Class DomainMail
 * @package Pentagonal\SlimHelper\Utilities
 */
class DomainMail
{
    const DOMAIN_SELECTOR     = 0;
    const SUB_DOMAIN_SELECTOR = 1;
    const EXTENSION_SELECTOR  = 2;
    const TLD_URL             = 'https://data.iana.org/TLD/tlds-alpha-by-domain.txt';

    /**
     * @see @link https://data.iana.org/TLD/tlds-alpha-by-domain.txt
     * @var array
     */
    protected static $tld = [
        'aaa' => 'aaa',
        'aarp' => 'aarp',
        'abarth' => 'abarth',
        'abb' => 'abb',
        'abbott' => 'abbott',
        'abbvie' => 'abbvie',
        'abc' => 'abc',
        'able' => 'able',
        'abogado' => 'abogado',
        'abudhabi' => 'abudhabi',
        'ac' => 'ac',
        'academy' => 'academy',
        'accenture' => 'accenture',
        'accountant' => 'accountant',
        'accountants' => 'accountants',
        'aco' => 'aco',
        'active' => 'active',
        'actor' => 'actor',
        'ad' => 'ad',
        'adac' => 'adac',
        'ads' => 'ads',
        'adult' => 'adult',
        'ae' => 'ae',
        'aeg' => 'aeg',
        'aero' => 'aero',
        'aetna' => 'aetna',
        'af' => 'af',
        'afamilycompany' => 'afamilycompany',
        'afl' => 'afl',
        'ag' => 'ag',
        'agakhan' => 'agakhan',
        'agency' => 'agency',
        'ai' => 'ai',
        'aig' => 'aig',
        'aigo' => 'aigo',
        'airbus' => 'airbus',
        'airforce' => 'airforce',
        'airtel' => 'airtel',
        'akdn' => 'akdn',
        'al' => 'al',
        'alfaromeo' => 'alfaromeo',
        'alibaba' => 'alibaba',
        'alipay' => 'alipay',
        'allfinanz' => 'allfinanz',
        'allstate' => 'allstate',
        'ally' => 'ally',
        'alsace' => 'alsace',
        'alstom' => 'alstom',
        'am' => 'am',
        'americanexpress' => 'americanexpress',
        'americanfamily' => 'americanfamily',
        'amex' => 'amex',
        'amfam' => 'amfam',
        'amica' => 'amica',
        'amsterdam' => 'amsterdam',
        'analytics' => 'analytics',
        'android' => 'android',
        'anquan' => 'anquan',
        'anz' => 'anz',
        'ao' => 'ao',
        'aol' => 'aol',
        'apartments' => 'apartments',
        'app' => 'app',
        'apple' => 'apple',
        'aq' => 'aq',
        'aquarelle' => 'aquarelle',
        'ar' => 'ar',
        'aramco' => 'aramco',
        'archi' => 'archi',
        'army' => 'army',
        'arpa' => 'arpa',
        'art' => 'art',
        'arte' => 'arte',
        'as' => 'as',
        'asda' => 'asda',
        'asia' => 'asia',
        'associates' => 'associates',
        'at' => 'at',
        'athleta' => 'athleta',
        'attorney' => 'attorney',
        'au' => 'au',
        'auction' => 'auction',
        'audi' => 'audi',
        'audible' => 'audible',
        'audio' => 'audio',
        'auspost' => 'auspost',
        'author' => 'author',
        'auto' => 'auto',
        'autos' => 'autos',
        'avianca' => 'avianca',
        'aw' => 'aw',
        'aws' => 'aws',
        'ax' => 'ax',
        'axa' => 'axa',
        'az' => 'az',
        'azure' => 'azure',
        'ba' => 'ba',
        'baby' => 'baby',
        'baidu' => 'baidu',
        'banamex' => 'banamex',
        'bananarepublic' => 'bananarepublic',
        'band' => 'band',
        'bank' => 'bank',
        'bar' => 'bar',
        'barcelona' => 'barcelona',
        'barclaycard' => 'barclaycard',
        'barclays' => 'barclays',
        'barefoot' => 'barefoot',
        'bargains' => 'bargains',
        'baseball' => 'baseball',
        'basketball' => 'basketball',
        'bauhaus' => 'bauhaus',
        'bayern' => 'bayern',
        'bb' => 'bb',
        'bbc' => 'bbc',
        'bbt' => 'bbt',
        'bbva' => 'bbva',
        'bcg' => 'bcg',
        'bcn' => 'bcn',
        'bd' => 'bd',
        'be' => 'be',
        'beats' => 'beats',
        'beauty' => 'beauty',
        'beer' => 'beer',
        'bentley' => 'bentley',
        'berlin' => 'berlin',
        'best' => 'best',
        'bestbuy' => 'bestbuy',
        'bet' => 'bet',
        'bf' => 'bf',
        'bg' => 'bg',
        'bh' => 'bh',
        'bharti' => 'bharti',
        'bi' => 'bi',
        'bible' => 'bible',
        'bid' => 'bid',
        'bike' => 'bike',
        'bing' => 'bing',
        'bingo' => 'bingo',
        'bio' => 'bio',
        'biz' => 'biz',
        'bj' => 'bj',
        'black' => 'black',
        'blackfriday' => 'blackfriday',
        'blanco' => 'blanco',
        'blockbuster' => 'blockbuster',
        'blog' => 'blog',
        'bloomberg' => 'bloomberg',
        'blue' => 'blue',
        'bm' => 'bm',
        'bms' => 'bms',
        'bmw' => 'bmw',
        'bn' => 'bn',
        'bnl' => 'bnl',
        'bnpparibas' => 'bnpparibas',
        'bo' => 'bo',
        'boats' => 'boats',
        'boehringer' => 'boehringer',
        'bofa' => 'bofa',
        'bom' => 'bom',
        'bond' => 'bond',
        'boo' => 'boo',
        'book' => 'book',
        'booking' => 'booking',
        'boots' => 'boots',
        'bosch' => 'bosch',
        'bostik' => 'bostik',
        'boston' => 'boston',
        'bot' => 'bot',
        'boutique' => 'boutique',
        'box' => 'box',
        'br' => 'br',
        'bradesco' => 'bradesco',
        'bridgestone' => 'bridgestone',
        'broadway' => 'broadway',
        'broker' => 'broker',
        'brother' => 'brother',
        'brussels' => 'brussels',
        'bs' => 'bs',
        'bt' => 'bt',
        'budapest' => 'budapest',
        'bugatti' => 'bugatti',
        'build' => 'build',
        'builders' => 'builders',
        'business' => 'business',
        'buy' => 'buy',
        'buzz' => 'buzz',
        'bv' => 'bv',
        'bw' => 'bw',
        'by' => 'by',
        'bz' => 'bz',
        'bzh' => 'bzh',
        'ca' => 'ca',
        'cab' => 'cab',
        'cafe' => 'cafe',
        'cal' => 'cal',
        'call' => 'call',
        'calvinklein' => 'calvinklein',
        'cam' => 'cam',
        'camera' => 'camera',
        'camp' => 'camp',
        'cancerresearch' => 'cancerresearch',
        'canon' => 'canon',
        'capetown' => 'capetown',
        'capital' => 'capital',
        'capitalone' => 'capitalone',
        'car' => 'car',
        'caravan' => 'caravan',
        'cards' => 'cards',
        'care' => 'care',
        'career' => 'career',
        'careers' => 'careers',
        'cars' => 'cars',
        'cartier' => 'cartier',
        'casa' => 'casa',
        'case' => 'case',
        'caseih' => 'caseih',
        'cash' => 'cash',
        'casino' => 'casino',
        'cat' => 'cat',
        'catering' => 'catering',
        'catholic' => 'catholic',
        'cba' => 'cba',
        'cbn' => 'cbn',
        'cbre' => 'cbre',
        'cbs' => 'cbs',
        'cc' => 'cc',
        'cd' => 'cd',
        'ceb' => 'ceb',
        'center' => 'center',
        'ceo' => 'ceo',
        'cern' => 'cern',
        'cf' => 'cf',
        'cfa' => 'cfa',
        'cfd' => 'cfd',
        'cg' => 'cg',
        'ch' => 'ch',
        'chanel' => 'chanel',
        'channel' => 'channel',
        'chase' => 'chase',
        'chat' => 'chat',
        'cheap' => 'cheap',
        'chintai' => 'chintai',
        'chloe' => 'chloe',
        'christmas' => 'christmas',
        'chrome' => 'chrome',
        'chrysler' => 'chrysler',
        'church' => 'church',
        'ci' => 'ci',
        'cipriani' => 'cipriani',
        'circle' => 'circle',
        'cisco' => 'cisco',
        'citadel' => 'citadel',
        'citi' => 'citi',
        'citic' => 'citic',
        'city' => 'city',
        'cityeats' => 'cityeats',
        'ck' => 'ck',
        'cl' => 'cl',
        'claims' => 'claims',
        'cleaning' => 'cleaning',
        'click' => 'click',
        'clinic' => 'clinic',
        'clinique' => 'clinique',
        'clothing' => 'clothing',
        'cloud' => 'cloud',
        'club' => 'club',
        'clubmed' => 'clubmed',
        'cm' => 'cm',
        'cn' => 'cn',
        'co' => 'co',
        'coach' => 'coach',
        'codes' => 'codes',
        'coffee' => 'coffee',
        'college' => 'college',
        'cologne' => 'cologne',
        'com' => 'com',
        'comcast' => 'comcast',
        'commbank' => 'commbank',
        'community' => 'community',
        'company' => 'company',
        'compare' => 'compare',
        'computer' => 'computer',
        'comsec' => 'comsec',
        'condos' => 'condos',
        'construction' => 'construction',
        'consulting' => 'consulting',
        'contact' => 'contact',
        'contractors' => 'contractors',
        'cooking' => 'cooking',
        'cookingchannel' => 'cookingchannel',
        'cool' => 'cool',
        'coop' => 'coop',
        'corsica' => 'corsica',
        'country' => 'country',
        'coupon' => 'coupon',
        'coupons' => 'coupons',
        'courses' => 'courses',
        'cr' => 'cr',
        'credit' => 'credit',
        'creditcard' => 'creditcard',
        'creditunion' => 'creditunion',
        'cricket' => 'cricket',
        'crown' => 'crown',
        'crs' => 'crs',
        'cruise' => 'cruise',
        'cruises' => 'cruises',
        'csc' => 'csc',
        'cu' => 'cu',
        'cuisinella' => 'cuisinella',
        'cv' => 'cv',
        'cw' => 'cw',
        'cx' => 'cx',
        'cy' => 'cy',
        'cymru' => 'cymru',
        'cyou' => 'cyou',
        'cz' => 'cz',
        'dabur' => 'dabur',
        'dad' => 'dad',
        'dance' => 'dance',
        'data' => 'data',
        'date' => 'date',
        'dating' => 'dating',
        'datsun' => 'datsun',
        'day' => 'day',
        'dclk' => 'dclk',
        'dds' => 'dds',
        'de' => 'de',
        'deal' => 'deal',
        'dealer' => 'dealer',
        'deals' => 'deals',
        'degree' => 'degree',
        'delivery' => 'delivery',
        'dell' => 'dell',
        'deloitte' => 'deloitte',
        'delta' => 'delta',
        'democrat' => 'democrat',
        'dental' => 'dental',
        'dentist' => 'dentist',
        'desi' => 'desi',
        'design' => 'design',
        'dev' => 'dev',
        'dhl' => 'dhl',
        'diamonds' => 'diamonds',
        'diet' => 'diet',
        'digital' => 'digital',
        'direct' => 'direct',
        'directory' => 'directory',
        'discount' => 'discount',
        'discover' => 'discover',
        'dish' => 'dish',
        'diy' => 'diy',
        'dj' => 'dj',
        'dk' => 'dk',
        'dm' => 'dm',
        'dnp' => 'dnp',
        'do' => 'do',
        'docs' => 'docs',
        'doctor' => 'doctor',
        'dodge' => 'dodge',
        'dog' => 'dog',
        'doha' => 'doha',
        'domains' => 'domains',
        'dot' => 'dot',
        'download' => 'download',
        'drive' => 'drive',
        'dtv' => 'dtv',
        'dubai' => 'dubai',
        'duck' => 'duck',
        'dunlop' => 'dunlop',
        'duns' => 'duns',
        'dupont' => 'dupont',
        'durban' => 'durban',
        'dvag' => 'dvag',
        'dvr' => 'dvr',
        'dz' => 'dz',
        'earth' => 'earth',
        'eat' => 'eat',
        'ec' => 'ec',
        'eco' => 'eco',
        'edeka' => 'edeka',
        'edu' => 'edu',
        'education' => 'education',
        'ee' => 'ee',
        'eg' => 'eg',
        'email' => 'email',
        'emerck' => 'emerck',
        'energy' => 'energy',
        'engineer' => 'engineer',
        'engineering' => 'engineering',
        'enterprises' => 'enterprises',
        'epost' => 'epost',
        'epson' => 'epson',
        'equipment' => 'equipment',
        'er' => 'er',
        'ericsson' => 'ericsson',
        'erni' => 'erni',
        'es' => 'es',
        'esq' => 'esq',
        'estate' => 'estate',
        'esurance' => 'esurance',
        'et' => 'et',
        'eu' => 'eu',
        'eurovision' => 'eurovision',
        'eus' => 'eus',
        'events' => 'events',
        'everbank' => 'everbank',
        'exchange' => 'exchange',
        'expert' => 'expert',
        'exposed' => 'exposed',
        'express' => 'express',
        'extraspace' => 'extraspace',
        'fage' => 'fage',
        'fail' => 'fail',
        'fairwinds' => 'fairwinds',
        'faith' => 'faith',
        'family' => 'family',
        'fan' => 'fan',
        'fans' => 'fans',
        'farm' => 'farm',
        'farmers' => 'farmers',
        'fashion' => 'fashion',
        'fast' => 'fast',
        'fedex' => 'fedex',
        'feedback' => 'feedback',
        'ferrari' => 'ferrari',
        'ferrero' => 'ferrero',
        'fi' => 'fi',
        'fiat' => 'fiat',
        'fidelity' => 'fidelity',
        'fido' => 'fido',
        'film' => 'film',
        'final' => 'final',
        'finance' => 'finance',
        'financial' => 'financial',
        'fire' => 'fire',
        'firestone' => 'firestone',
        'firmdale' => 'firmdale',
        'fish' => 'fish',
        'fishing' => 'fishing',
        'fit' => 'fit',
        'fitness' => 'fitness',
        'fj' => 'fj',
        'fk' => 'fk',
        'flickr' => 'flickr',
        'flights' => 'flights',
        'flir' => 'flir',
        'florist' => 'florist',
        'flowers' => 'flowers',
        'flsmidth' => 'flsmidth',
        'fly' => 'fly',
        'fm' => 'fm',
        'fo' => 'fo',
        'foo' => 'foo',
        'food' => 'food',
        'foodnetwork' => 'foodnetwork',
        'football' => 'football',
        'ford' => 'ford',
        'forex' => 'forex',
        'forsale' => 'forsale',
        'forum' => 'forum',
        'foundation' => 'foundation',
        'fox' => 'fox',
        'fr' => 'fr',
        'free' => 'free',
        'fresenius' => 'fresenius',
        'frl' => 'frl',
        'frogans' => 'frogans',
        'frontdoor' => 'frontdoor',
        'frontier' => 'frontier',
        'ftr' => 'ftr',
        'fujitsu' => 'fujitsu',
        'fujixerox' => 'fujixerox',
        'fun' => 'fun',
        'fund' => 'fund',
        'furniture' => 'furniture',
        'futbol' => 'futbol',
        'fyi' => 'fyi',
        'ga' => 'ga',
        'gal' => 'gal',
        'gallery' => 'gallery',
        'gallo' => 'gallo',
        'gallup' => 'gallup',
        'game' => 'game',
        'games' => 'games',
        'gap' => 'gap',
        'garden' => 'garden',
        'gb' => 'gb',
        'gbiz' => 'gbiz',
        'gd' => 'gd',
        'gdn' => 'gdn',
        'ge' => 'ge',
        'gea' => 'gea',
        'gent' => 'gent',
        'genting' => 'genting',
        'george' => 'george',
        'gf' => 'gf',
        'gg' => 'gg',
        'ggee' => 'ggee',
        'gh' => 'gh',
        'gi' => 'gi',
        'gift' => 'gift',
        'gifts' => 'gifts',
        'gives' => 'gives',
        'giving' => 'giving',
        'gl' => 'gl',
        'glade' => 'glade',
        'glass' => 'glass',
        'gle' => 'gle',
        'global' => 'global',
        'globo' => 'globo',
        'gm' => 'gm',
        'gmail' => 'gmail',
        'gmbh' => 'gmbh',
        'gmo' => 'gmo',
        'gmx' => 'gmx',
        'gn' => 'gn',
        'godaddy' => 'godaddy',
        'gold' => 'gold',
        'goldpoint' => 'goldpoint',
        'golf' => 'golf',
        'goo' => 'goo',
        'goodhands' => 'goodhands',
        'goodyear' => 'goodyear',
        'goog' => 'goog',
        'google' => 'google',
        'gop' => 'gop',
        'got' => 'got',
        'gov' => 'gov',
        'gp' => 'gp',
        'gq' => 'gq',
        'gr' => 'gr',
        'grainger' => 'grainger',
        'graphics' => 'graphics',
        'gratis' => 'gratis',
        'green' => 'green',
        'gripe' => 'gripe',
        'group' => 'group',
        'gs' => 'gs',
        'gt' => 'gt',
        'gu' => 'gu',
        'guardian' => 'guardian',
        'gucci' => 'gucci',
        'guge' => 'guge',
        'guide' => 'guide',
        'guitars' => 'guitars',
        'guru' => 'guru',
        'gw' => 'gw',
        'gy' => 'gy',
        'hair' => 'hair',
        'hamburg' => 'hamburg',
        'hangout' => 'hangout',
        'haus' => 'haus',
        'hbo' => 'hbo',
        'hdfc' => 'hdfc',
        'hdfcbank' => 'hdfcbank',
        'health' => 'health',
        'healthcare' => 'healthcare',
        'help' => 'help',
        'helsinki' => 'helsinki',
        'here' => 'here',
        'hermes' => 'hermes',
        'hgtv' => 'hgtv',
        'hiphop' => 'hiphop',
        'hisamitsu' => 'hisamitsu',
        'hitachi' => 'hitachi',
        'hiv' => 'hiv',
        'hk' => 'hk',
        'hkt' => 'hkt',
        'hm' => 'hm',
        'hn' => 'hn',
        'hockey' => 'hockey',
        'holdings' => 'holdings',
        'holiday' => 'holiday',
        'homedepot' => 'homedepot',
        'homegoods' => 'homegoods',
        'homes' => 'homes',
        'homesense' => 'homesense',
        'honda' => 'honda',
        'honeywell' => 'honeywell',
        'horse' => 'horse',
        'hospital' => 'hospital',
        'host' => 'host',
        'hosting' => 'hosting',
        'hot' => 'hot',
        'hoteles' => 'hoteles',
        'hotmail' => 'hotmail',
        'house' => 'house',
        'how' => 'how',
        'hr' => 'hr',
        'hsbc' => 'hsbc',
        'ht' => 'ht',
        'htc' => 'htc',
        'hu' => 'hu',
        'hughes' => 'hughes',
        'hyatt' => 'hyatt',
        'hyundai' => 'hyundai',
        'ibm' => 'ibm',
        'icbc' => 'icbc',
        'ice' => 'ice',
        'icu' => 'icu',
        'id' => 'id',
        'ie' => 'ie',
        'ieee' => 'ieee',
        'ifm' => 'ifm',
        'iinet' => 'iinet',
        'ikano' => 'ikano',
        'il' => 'il',
        'im' => 'im',
        'imamat' => 'imamat',
        'imdb' => 'imdb',
        'immo' => 'immo',
        'immobilien' => 'immobilien',
        'in' => 'in',
        'industries' => 'industries',
        'infiniti' => 'infiniti',
        'info' => 'info',
        'ing' => 'ing',
        'ink' => 'ink',
        'institute' => 'institute',
        'insurance' => 'insurance',
        'insure' => 'insure',
        'int' => 'int',
        'intel' => 'intel',
        'international' => 'international',
        'intuit' => 'intuit',
        'investments' => 'investments',
        'io' => 'io',
        'ipiranga' => 'ipiranga',
        'iq' => 'iq',
        'ir' => 'ir',
        'irish' => 'irish',
        'is' => 'is',
        'iselect' => 'iselect',
        'ismaili' => 'ismaili',
        'ist' => 'ist',
        'istanbul' => 'istanbul',
        'it' => 'it',
        'itau' => 'itau',
        'itv' => 'itv',
        'iveco' => 'iveco',
        'iwc' => 'iwc',
        'jaguar' => 'jaguar',
        'java' => 'java',
        'jcb' => 'jcb',
        'jcp' => 'jcp',
        'je' => 'je',
        'jeep' => 'jeep',
        'jetzt' => 'jetzt',
        'jewelry' => 'jewelry',
        'jio' => 'jio',
        'jlc' => 'jlc',
        'jll' => 'jll',
        'jm' => 'jm',
        'jmp' => 'jmp',
        'jnj' => 'jnj',
        'jo' => 'jo',
        'jobs' => 'jobs',
        'joburg' => 'joburg',
        'jot' => 'jot',
        'joy' => 'joy',
        'jp' => 'jp',
        'jpmorgan' => 'jpmorgan',
        'jprs' => 'jprs',
        'juegos' => 'juegos',
        'juniper' => 'juniper',
        'kaufen' => 'kaufen',
        'kddi' => 'kddi',
        'ke' => 'ke',
        'kerryhotels' => 'kerryhotels',
        'kerrylogistics' => 'kerrylogistics',
        'kerryproperties' => 'kerryproperties',
        'kfh' => 'kfh',
        'kg' => 'kg',
        'kh' => 'kh',
        'ki' => 'ki',
        'kia' => 'kia',
        'kim' => 'kim',
        'kinder' => 'kinder',
        'kindle' => 'kindle',
        'kitchen' => 'kitchen',
        'kiwi' => 'kiwi',
        'km' => 'km',
        'kn' => 'kn',
        'koeln' => 'koeln',
        'komatsu' => 'komatsu',
        'kosher' => 'kosher',
        'kp' => 'kp',
        'kpmg' => 'kpmg',
        'kpn' => 'kpn',
        'kr' => 'kr',
        'krd' => 'krd',
        'kred' => 'kred',
        'kuokgroup' => 'kuokgroup',
        'kw' => 'kw',
        'ky' => 'ky',
        'kyoto' => 'kyoto',
        'kz' => 'kz',
        'la' => 'la',
        'lacaixa' => 'lacaixa',
        'ladbrokes' => 'ladbrokes',
        'lamborghini' => 'lamborghini',
        'lamer' => 'lamer',
        'lancaster' => 'lancaster',
        'lancia' => 'lancia',
        'lancome' => 'lancome',
        'land' => 'land',
        'landrover' => 'landrover',
        'lanxess' => 'lanxess',
        'lasalle' => 'lasalle',
        'lat' => 'lat',
        'latino' => 'latino',
        'latrobe' => 'latrobe',
        'law' => 'law',
        'lawyer' => 'lawyer',
        'lb' => 'lb',
        'lc' => 'lc',
        'lds' => 'lds',
        'lease' => 'lease',
        'leclerc' => 'leclerc',
        'lefrak' => 'lefrak',
        'legal' => 'legal',
        'lego' => 'lego',
        'lexus' => 'lexus',
        'lgbt' => 'lgbt',
        'li' => 'li',
        'liaison' => 'liaison',
        'lidl' => 'lidl',
        'life' => 'life',
        'lifeinsurance' => 'lifeinsurance',
        'lifestyle' => 'lifestyle',
        'lighting' => 'lighting',
        'like' => 'like',
        'lilly' => 'lilly',
        'limited' => 'limited',
        'limo' => 'limo',
        'lincoln' => 'lincoln',
        'linde' => 'linde',
        'link' => 'link',
        'lipsy' => 'lipsy',
        'live' => 'live',
        'living' => 'living',
        'lixil' => 'lixil',
        'lk' => 'lk',
        'loan' => 'loan',
        'loans' => 'loans',
        'locker' => 'locker',
        'locus' => 'locus',
        'loft' => 'loft',
        'lol' => 'lol',
        'london' => 'london',
        'lotte' => 'lotte',
        'lotto' => 'lotto',
        'love' => 'love',
        'lpl' => 'lpl',
        'lplfinancial' => 'lplfinancial',
        'lr' => 'lr',
        'ls' => 'ls',
        'lt' => 'lt',
        'ltd' => 'ltd',
        'ltda' => 'ltda',
        'lu' => 'lu',
        'lundbeck' => 'lundbeck',
        'lupin' => 'lupin',
        'luxe' => 'luxe',
        'luxury' => 'luxury',
        'lv' => 'lv',
        'ly' => 'ly',
        'ma' => 'ma',
        'macys' => 'macys',
        'madrid' => 'madrid',
        'maif' => 'maif',
        'maison' => 'maison',
        'makeup' => 'makeup',
        'man' => 'man',
        'management' => 'management',
        'mango' => 'mango',
        'market' => 'market',
        'marketing' => 'marketing',
        'markets' => 'markets',
        'marriott' => 'marriott',
        'marshalls' => 'marshalls',
        'maserati' => 'maserati',
        'mattel' => 'mattel',
        'mba' => 'mba',
        'mc' => 'mc',
        'mcd' => 'mcd',
        'mcdonalds' => 'mcdonalds',
        'mckinsey' => 'mckinsey',
        'md' => 'md',
        'me' => 'me',
        'med' => 'med',
        'media' => 'media',
        'meet' => 'meet',
        'melbourne' => 'melbourne',
        'meme' => 'meme',
        'memorial' => 'memorial',
        'men' => 'men',
        'menu' => 'menu',
        'meo' => 'meo',
        'metlife' => 'metlife',
        'mg' => 'mg',
        'mh' => 'mh',
        'miami' => 'miami',
        'microsoft' => 'microsoft',
        'mil' => 'mil',
        'mini' => 'mini',
        'mint' => 'mint',
        'mit' => 'mit',
        'mitsubishi' => 'mitsubishi',
        'mk' => 'mk',
        'ml' => 'ml',
        'mlb' => 'mlb',
        'mls' => 'mls',
        'mm' => 'mm',
        'mma' => 'mma',
        'mn' => 'mn',
        'mo' => 'mo',
        'mobi' => 'mobi',
        'mobile' => 'mobile',
        'mobily' => 'mobily',
        'moda' => 'moda',
        'moe' => 'moe',
        'moi' => 'moi',
        'mom' => 'mom',
        'monash' => 'monash',
        'money' => 'money',
        'monster' => 'monster',
        'montblanc' => 'montblanc',
        'mopar' => 'mopar',
        'mormon' => 'mormon',
        'mortgage' => 'mortgage',
        'moscow' => 'moscow',
        'moto' => 'moto',
        'motorcycles' => 'motorcycles',
        'mov' => 'mov',
        'movie' => 'movie',
        'movistar' => 'movistar',
        'mp' => 'mp',
        'mq' => 'mq',
        'mr' => 'mr',
        'ms' => 'ms',
        'msd' => 'msd',
        'mt' => 'mt',
        'mtn' => 'mtn',
        'mtpc' => 'mtpc',
        'mtr' => 'mtr',
        'mu' => 'mu',
        'museum' => 'museum',
        'mutual' => 'mutual',
        'mutuelle' => 'mutuelle',
        'mv' => 'mv',
        'mw' => 'mw',
        'mx' => 'mx',
        'my' => 'my',
        'mz' => 'mz',
        'na' => 'na',
        'nab' => 'nab',
        'nadex' => 'nadex',
        'nagoya' => 'nagoya',
        'name' => 'name',
        'nationwide' => 'nationwide',
        'natura' => 'natura',
        'navy' => 'navy',
        'nba' => 'nba',
        'nc' => 'nc',
        'ne' => 'ne',
        'nec' => 'nec',
        'net' => 'net',
        'netbank' => 'netbank',
        'netflix' => 'netflix',
        'network' => 'network',
        'neustar' => 'neustar',
        'new' => 'new',
        'newholland' => 'newholland',
        'news' => 'news',
        'next' => 'next',
        'nextdirect' => 'nextdirect',
        'nexus' => 'nexus',
        'nf' => 'nf',
        'nfl' => 'nfl',
        'ng' => 'ng',
        'ngo' => 'ngo',
        'nhk' => 'nhk',
        'ni' => 'ni',
        'nico' => 'nico',
        'nike' => 'nike',
        'nikon' => 'nikon',
        'ninja' => 'ninja',
        'nissan' => 'nissan',
        'nissay' => 'nissay',
        'nl' => 'nl',
        'no' => 'no',
        'nokia' => 'nokia',
        'northwesternmutual' => 'northwesternmutual',
        'norton' => 'norton',
        'now' => 'now',
        'nowruz' => 'nowruz',
        'nowtv' => 'nowtv',
        'np' => 'np',
        'nr' => 'nr',
        'nra' => 'nra',
        'nrw' => 'nrw',
        'ntt' => 'ntt',
        'nu' => 'nu',
        'nyc' => 'nyc',
        'nz' => 'nz',
        'obi' => 'obi',
        'observer' => 'observer',
        'off' => 'off',
        'office' => 'office',
        'okinawa' => 'okinawa',
        'olayan' => 'olayan',
        'olayangroup' => 'olayangroup',
        'oldnavy' => 'oldnavy',
        'ollo' => 'ollo',
        'om' => 'om',
        'omega' => 'omega',
        'one' => 'one',
        'ong' => 'ong',
        'onl' => 'onl',
        'online' => 'online',
        'onyourside' => 'onyourside',
        'ooo' => 'ooo',
        'open' => 'open',
        'oracle' => 'oracle',
        'orange' => 'orange',
        'org' => 'org',
        'organic' => 'organic',
        'orientexpress' => 'orientexpress',
        'origins' => 'origins',
        'osaka' => 'osaka',
        'otsuka' => 'otsuka',
        'ott' => 'ott',
        'ovh' => 'ovh',
        'pa' => 'pa',
        'page' => 'page',
        'pamperedchef' => 'pamperedchef',
        'panasonic' => 'panasonic',
        'panerai' => 'panerai',
        'paris' => 'paris',
        'pars' => 'pars',
        'partners' => 'partners',
        'parts' => 'parts',
        'party' => 'party',
        'passagens' => 'passagens',
        'pay' => 'pay',
        'pccw' => 'pccw',
        'pe' => 'pe',
        'pet' => 'pet',
        'pf' => 'pf',
        'pfizer' => 'pfizer',
        'pg' => 'pg',
        'ph' => 'ph',
        'pharmacy' => 'pharmacy',
        'philips' => 'philips',
        'phone' => 'phone',
        'photo' => 'photo',
        'photography' => 'photography',
        'photos' => 'photos',
        'physio' => 'physio',
        'piaget' => 'piaget',
        'pics' => 'pics',
        'pictet' => 'pictet',
        'pictures' => 'pictures',
        'pid' => 'pid',
        'pin' => 'pin',
        'ping' => 'ping',
        'pink' => 'pink',
        'pioneer' => 'pioneer',
        'pizza' => 'pizza',
        'pk' => 'pk',
        'pl' => 'pl',
        'place' => 'place',
        'play' => 'play',
        'playstation' => 'playstation',
        'plumbing' => 'plumbing',
        'plus' => 'plus',
        'pm' => 'pm',
        'pn' => 'pn',
        'pnc' => 'pnc',
        'pohl' => 'pohl',
        'poker' => 'poker',
        'politie' => 'politie',
        'porn' => 'porn',
        'post' => 'post',
        'pr' => 'pr',
        'pramerica' => 'pramerica',
        'praxi' => 'praxi',
        'press' => 'press',
        'prime' => 'prime',
        'pro' => 'pro',
        'prod' => 'prod',
        'productions' => 'productions',
        'prof' => 'prof',
        'progressive' => 'progressive',
        'promo' => 'promo',
        'properties' => 'properties',
        'property' => 'property',
        'protection' => 'protection',
        'pru' => 'pru',
        'prudential' => 'prudential',
        'ps' => 'ps',
        'pt' => 'pt',
        'pub' => 'pub',
        'pw' => 'pw',
        'pwc' => 'pwc',
        'py' => 'py',
        'qa' => 'qa',
        'qpon' => 'qpon',
        'quebec' => 'quebec',
        'quest' => 'quest',
        'qvc' => 'qvc',
        'racing' => 'racing',
        'radio' => 'radio',
        'raid' => 'raid',
        're' => 're',
        'read' => 'read',
        'realestate' => 'realestate',
        'realtor' => 'realtor',
        'realty' => 'realty',
        'recipes' => 'recipes',
        'red' => 'red',
        'redstone' => 'redstone',
        'redumbrella' => 'redumbrella',
        'rehab' => 'rehab',
        'reise' => 'reise',
        'reisen' => 'reisen',
        'reit' => 'reit',
        'reliance' => 'reliance',
        'ren' => 'ren',
        'rent' => 'rent',
        'rentals' => 'rentals',
        'repair' => 'repair',
        'report' => 'report',
        'republican' => 'republican',
        'rest' => 'rest',
        'restaurant' => 'restaurant',
        'review' => 'review',
        'reviews' => 'reviews',
        'rexroth' => 'rexroth',
        'rich' => 'rich',
        'richardli' => 'richardli',
        'ricoh' => 'ricoh',
        'rightathome' => 'rightathome',
        'ril' => 'ril',
        'rio' => 'rio',
        'rip' => 'rip',
        'rmit' => 'rmit',
        'ro' => 'ro',
        'rocher' => 'rocher',
        'rocks' => 'rocks',
        'rodeo' => 'rodeo',
        'rogers' => 'rogers',
        'room' => 'room',
        'rs' => 'rs',
        'rsvp' => 'rsvp',
        'ru' => 'ru',
        'ruhr' => 'ruhr',
        'run' => 'run',
        'rw' => 'rw',
        'rwe' => 'rwe',
        'ryukyu' => 'ryukyu',
        'sa' => 'sa',
        'saarland' => 'saarland',
        'safe' => 'safe',
        'safety' => 'safety',
        'sakura' => 'sakura',
        'sale' => 'sale',
        'salon' => 'salon',
        'samsclub' => 'samsclub',
        'samsung' => 'samsung',
        'sandvik' => 'sandvik',
        'sandvikcoromant' => 'sandvikcoromant',
        'sanofi' => 'sanofi',
        'sap' => 'sap',
        'sapo' => 'sapo',
        'sarl' => 'sarl',
        'sas' => 'sas',
        'save' => 'save',
        'saxo' => 'saxo',
        'sb' => 'sb',
        'sbi' => 'sbi',
        'sbs' => 'sbs',
        'sc' => 'sc',
        'sca' => 'sca',
        'scb' => 'scb',
        'schaeffler' => 'schaeffler',
        'schmidt' => 'schmidt',
        'scholarships' => 'scholarships',
        'school' => 'school',
        'schule' => 'schule',
        'schwarz' => 'schwarz',
        'science' => 'science',
        'scjohnson' => 'scjohnson',
        'scor' => 'scor',
        'scot' => 'scot',
        'sd' => 'sd',
        'se' => 'se',
        'seat' => 'seat',
        'secure' => 'secure',
        'security' => 'security',
        'seek' => 'seek',
        'select' => 'select',
        'sener' => 'sener',
        'services' => 'services',
        'ses' => 'ses',
        'seven' => 'seven',
        'sew' => 'sew',
        'sex' => 'sex',
        'sexy' => 'sexy',
        'sfr' => 'sfr',
        'sg' => 'sg',
        'sh' => 'sh',
        'shangrila' => 'shangrila',
        'sharp' => 'sharp',
        'shaw' => 'shaw',
        'shell' => 'shell',
        'shia' => 'shia',
        'shiksha' => 'shiksha',
        'shoes' => 'shoes',
        'shop' => 'shop',
        'shopping' => 'shopping',
        'shouji' => 'shouji',
        'show' => 'show',
        'showtime' => 'showtime',
        'shriram' => 'shriram',
        'si' => 'si',
        'silk' => 'silk',
        'sina' => 'sina',
        'singles' => 'singles',
        'site' => 'site',
        'sj' => 'sj',
        'sk' => 'sk',
        'ski' => 'ski',
        'skin' => 'skin',
        'sky' => 'sky',
        'skype' => 'skype',
        'sl' => 'sl',
        'sling' => 'sling',
        'sm' => 'sm',
        'smart' => 'smart',
        'smile' => 'smile',
        'sn' => 'sn',
        'sncf' => 'sncf',
        'so' => 'so',
        'soccer' => 'soccer',
        'social' => 'social',
        'softbank' => 'softbank',
        'software' => 'software',
        'sohu' => 'sohu',
        'solar' => 'solar',
        'solutions' => 'solutions',
        'song' => 'song',
        'sony' => 'sony',
        'soy' => 'soy',
        'space' => 'space',
        'spiegel' => 'spiegel',
        'spot' => 'spot',
        'spreadbetting' => 'spreadbetting',
        'sr' => 'sr',
        'srl' => 'srl',
        'srt' => 'srt',
        'st' => 'st',
        'stada' => 'stada',
        'staples' => 'staples',
        'star' => 'star',
        'starhub' => 'starhub',
        'statebank' => 'statebank',
        'statefarm' => 'statefarm',
        'statoil' => 'statoil',
        'stc' => 'stc',
        'stcgroup' => 'stcgroup',
        'stockholm' => 'stockholm',
        'storage' => 'storage',
        'store' => 'store',
        'stream' => 'stream',
        'studio' => 'studio',
        'study' => 'study',
        'style' => 'style',
        'su' => 'su',
        'sucks' => 'sucks',
        'supplies' => 'supplies',
        'supply' => 'supply',
        'support' => 'support',
        'surf' => 'surf',
        'surgery' => 'surgery',
        'suzuki' => 'suzuki',
        'sv' => 'sv',
        'swatch' => 'swatch',
        'swiftcover' => 'swiftcover',
        'swiss' => 'swiss',
        'sx' => 'sx',
        'sy' => 'sy',
        'sydney' => 'sydney',
        'symantec' => 'symantec',
        'systems' => 'systems',
        'sz' => 'sz',
        'tab' => 'tab',
        'taipei' => 'taipei',
        'talk' => 'talk',
        'taobao' => 'taobao',
        'target' => 'target',
        'tatamotors' => 'tatamotors',
        'tatar' => 'tatar',
        'tattoo' => 'tattoo',
        'tax' => 'tax',
        'taxi' => 'taxi',
        'tc' => 'tc',
        'tci' => 'tci',
        'td' => 'td',
        'tdk' => 'tdk',
        'team' => 'team',
        'tech' => 'tech',
        'technology' => 'technology',
        'tel' => 'tel',
        'telecity' => 'telecity',
        'telefonica' => 'telefonica',
        'temasek' => 'temasek',
        'tennis' => 'tennis',
        'teva' => 'teva',
        'tf' => 'tf',
        'tg' => 'tg',
        'th' => 'th',
        'thd' => 'thd',
        'theater' => 'theater',
        'theatre' => 'theatre',
        'tiaa' => 'tiaa',
        'tickets' => 'tickets',
        'tienda' => 'tienda',
        'tiffany' => 'tiffany',
        'tips' => 'tips',
        'tires' => 'tires',
        'tirol' => 'tirol',
        'tj' => 'tj',
        'tjmaxx' => 'tjmaxx',
        'tjx' => 'tjx',
        'tk' => 'tk',
        'tkmaxx' => 'tkmaxx',
        'tl' => 'tl',
        'tm' => 'tm',
        'tmall' => 'tmall',
        'tn' => 'tn',
        'to' => 'to',
        'today' => 'today',
        'tokyo' => 'tokyo',
        'tools' => 'tools',
        'top' => 'top',
        'toray' => 'toray',
        'toshiba' => 'toshiba',
        'total' => 'total',
        'tours' => 'tours',
        'town' => 'town',
        'toyota' => 'toyota',
        'toys' => 'toys',
        'tr' => 'tr',
        'trade' => 'trade',
        'trading' => 'trading',
        'training' => 'training',
        'travel' => 'travel',
        'travelchannel' => 'travelchannel',
        'travelers' => 'travelers',
        'travelersinsurance' => 'travelersinsurance',
        'trust' => 'trust',
        'trv' => 'trv',
        'tt' => 'tt',
        'tube' => 'tube',
        'tui' => 'tui',
        'tunes' => 'tunes',
        'tushu' => 'tushu',
        'tv' => 'tv',
        'tvs' => 'tvs',
        'tw' => 'tw',
        'tz' => 'tz',
        'ua' => 'ua',
        'ubank' => 'ubank',
        'ubs' => 'ubs',
        'uconnect' => 'uconnect',
        'ug' => 'ug',
        'uk' => 'uk',
        'unicom' => 'unicom',
        'university' => 'university',
        'uno' => 'uno',
        'uol' => 'uol',
        'ups' => 'ups',
        'us' => 'us',
        'uy' => 'uy',
        'uz' => 'uz',
        'va' => 'va',
        'vacations' => 'vacations',
        'vana' => 'vana',
        'vanguard' => 'vanguard',
        'vc' => 'vc',
        've' => 've',
        'vegas' => 'vegas',
        'ventures' => 'ventures',
        'verisign' => 'verisign',
        'versicherung' => 'versicherung',
        'vet' => 'vet',
        'vg' => 'vg',
        'vi' => 'vi',
        'viajes' => 'viajes',
        'video' => 'video',
        'vig' => 'vig',
        'viking' => 'viking',
        'villas' => 'villas',
        'vin' => 'vin',
        'vip' => 'vip',
        'virgin' => 'virgin',
        'visa' => 'visa',
        'vision' => 'vision',
        'vista' => 'vista',
        'vistaprint' => 'vistaprint',
        'viva' => 'viva',
        'vivo' => 'vivo',
        'vlaanderen' => 'vlaanderen',
        'vn' => 'vn',
        'vodka' => 'vodka',
        'volkswagen' => 'volkswagen',
        'volvo' => 'volvo',
        'vote' => 'vote',
        'voting' => 'voting',
        'voto' => 'voto',
        'voyage' => 'voyage',
        'vu' => 'vu',
        'vuelos' => 'vuelos',
        'wales' => 'wales',
        'walmart' => 'walmart',
        'walter' => 'walter',
        'wang' => 'wang',
        'wanggou' => 'wanggou',
        'warman' => 'warman',
        'watch' => 'watch',
        'watches' => 'watches',
        'weather' => 'weather',
        'weatherchannel' => 'weatherchannel',
        'webcam' => 'webcam',
        'weber' => 'weber',
        'website' => 'website',
        'wed' => 'wed',
        'wedding' => 'wedding',
        'weibo' => 'weibo',
        'weir' => 'weir',
        'wf' => 'wf',
        'whoswho' => 'whoswho',
        'wien' => 'wien',
        'wiki' => 'wiki',
        'williamhill' => 'williamhill',
        'win' => 'win',
        'windows' => 'windows',
        'wine' => 'wine',
        'winners' => 'winners',
        'wme' => 'wme',
        'wolterskluwer' => 'wolterskluwer',
        'woodside' => 'woodside',
        'work' => 'work',
        'works' => 'works',
        'world' => 'world',
        'wow' => 'wow',
        'ws' => 'ws',
        'wtc' => 'wtc',
        'wtf' => 'wtf',
        'xbox' => 'xbox',
        'xerox' => 'xerox',
        'xfinity' => 'xfinity',
        'xihuan' => 'xihuan',
        'xin' => 'xin',
        'xn--11b4c3d' => 'कॉम',
        'xn--1ck2e1b' => 'セール',
        'xn--1qqw23a' => '佛山',
        'xn--30rr7y' => '慈善',
        'xn--3bst00m' => '集团',
        'xn--3ds443g' => '在线',
        'xn--3e0b707e' => '한국',
        'xn--3pxu8k' => '点看',
        'xn--42c2d9a' => 'คอม',
        'xn--45brj9c' => 'ভারত',
        'xn--45q11c' => '八卦',
        'xn--4gbrim' => 'موقع',
        'xn--55qw42g' => '公益',
        'xn--55qx5d' => '公司',
        'xn--5tzm5g' => '网站',
        'xn--6frz82g' => '移动',
        'xn--6qq986b3xl' => '我爱你',
        'xn--80adxhks' => 'москва',
        'xn--80ao21a' => 'қаз',
        'xn--80asehdb' => 'онлайн',
        'xn--80aswg' => 'сайт',
        'xn--8y0a063a' => '联通',
        'xn--90a3ac' => 'срб',
        'xn--90ais' => 'бел',
        'xn--9dbq2a' => 'קום',
        'xn--9et52u' => '时尚',
        'xn--9krt00a' => '微博',
        'xn--b4w605ferd' => '淡马锡',
        'xn--bck1b9a5dre4c' => 'ファッション',
        'xn--c1avg' => 'орг',
        'xn--c2br7g' => 'नेट',
        'xn--cck2b3b' => 'ストア',
        'xn--cg4bki' => '삼성',
        'xn--clchc0ea0b2g2a9gcd' => 'சிங்கப்பூர்',
        'xn--czr694b' => '商标',
        'xn--czrs0t' => '商店',
        'xn--czru2d' => '商城',
        'xn--d1acj3b' => 'дети',
        'xn--d1alf' => 'мкд',
        'xn--e1a4c' => 'ею',
        'xn--eckvdtc9d' => 'ポイント',
        'xn--efvy88h' => '新闻',
        'xn--estv75g' => '工行',
        'xn--fct429k' => '家電',
        'xn--fhbei' => 'كوم',
        'xn--fiq228c5hs' => '中文网',
        'xn--fiq64b' => '中信',
        'xn--fiqs8s' => '中国',
        'xn--fiqz9s' => '中國',
        'xn--fjq720a' => '娱乐',
        'xn--flw351e' => '谷歌',
        'xn--fpcrj9c3d' => 'భారత్',
        'xn--fzc2c9e2c' => 'ලංකා',
        'xn--fzys8d69uvgm' => '電訊盈科',
        'xn--g2xx48c' => '购物',
        'xn--gckr3f0f' => 'クラウド',
        'xn--gecrj9c' => 'ભારત',
        'xn--h2brj9c' => 'भारत',
        'xn--hxt814e' => '网店',
        'xn--i1b6b1a6a2e' => 'संगठन',
        'xn--imr513n' => '餐厅',
        'xn--io0a7i' => '网络',
        'xn--j1aef' => 'ком',
        'xn--j1amh' => 'укр',
        'xn--j6w193g' => '香港',
        'xn--jlq61u9w7b' => '诺基亚',
        'xn--jvr189m' => '食品',
        'xn--kcrx77d1x4a' => '飞利浦',
        'xn--kprw13d' => '台湾',
        'xn--kpry57d' => '台灣',
        'xn--kpu716f' => '手表',
        'xn--kput3i' => '手机',
        'xn--l1acc' => 'мон',
        'xn--lgbbat1ad8j' => 'الجزائر',
        'xn--mgb9awbf' => 'عمان',
        'xn--mgba3a3ejt' => 'ارامكو',
        'xn--mgba3a4f16a' => 'ایران',
        'xn--mgba7c0bbn0a' => 'العليان',
        'xn--mgbaam7a8h' => 'امارات',
        'xn--mgbab2bd' => 'بازار',
        'xn--mgbayh7gpa' => 'الاردن',
        'xn--mgbb9fbpob' => 'موبايلي',
        'xn--mgbbh1a71e' => 'بھارت',
        'xn--mgbc0a9azcg' => 'المغرب',
        'xn--mgbca7dzdo' => 'ابوظبي',
        'xn--mgberp4a5d4ar' => 'السعودية',
        'xn--mgbpl2fh' => 'سودان',
        'xn--mgbt3dhd' => 'همراه',
        'xn--mgbtx2b' => 'عراق',
        'xn--mgbx4cd0ab' => 'مليسيا',
        'xn--mix891f' => '澳門',
        'xn--mk1bu44c' => '닷컴',
        'xn--mxtq1m' => '政府',
        'xn--ngbc5azd' => 'شبكة',
        'xn--ngbe9e0a' => 'بيتك',
        'xn--node' => 'გე',
        'xn--nqv7f' => '机构',
        'xn--nqv7fs00ema' => '组织机构',
        'xn--nyqy26a' => '健康',
        'xn--o3cw4h' => 'ไทย',
        'xn--ogbpf8fl' => 'سورية',
        'xn--p1acf' => 'рус',
        'xn--p1ai' => 'рф',
        'xn--pbt977c' => '珠宝',
        'xn--pgbs0dh' => 'تونس',
        'xn--pssy2u' => '大拿',
        'xn--q9jyb4c' => 'みんな',
        'xn--qcka1pmc' => 'グーグル',
        'xn--qxam' => 'ελ',
        'xn--rhqv96g' => '世界',
        'xn--rovu88b' => '書籍',
        'xn--s9brj9c' => 'ਭਾਰਤ',
        'xn--ses554g' => '网址',
        'xn--t60b56a' => '닷넷',
        'xn--tckwe' => 'コム',
        'xn--unup4y' => '游戏',
        'xn--vermgensberater-ctb' => 'vermögensberater',
        'xn--vermgensberatung-pwb' => 'vermögensberatung',
        'xn--vhquv' => '企业',
        'xn--vuq861b' => '信息',
        'xn--w4r85el8fhu5dnra' => '嘉里大酒店',
        'xn--w4rs40l' => '嘉里',
        'xn--wgbh1c' => 'مصر',
        'xn--wgbl6a' => 'قطر',
        'xn--xhq521b' => '广东',
        'xn--xkc2al3hye2a' => 'இலங்கை',
        'xn--xkc2dl3a5ee0h' => 'இந்தியா',
        'xn--y9a3aq' => 'հայ',
        'xn--yfro4i67o' => '新加坡',
        'xn--ygbi2ammx' => 'فلسطين',
        'xn--zfr164b' => '政务',
        'xperia' => 'xperia',
        'xxx' => 'xxx',
        'xyz' => 'xyz',
        'yachts' => 'yachts',
        'yahoo' => 'yahoo',
        'yamaxun' => 'yamaxun',
        'yandex' => 'yandex',
        'ye' => 'ye',
        'yodobashi' => 'yodobashi',
        'yoga' => 'yoga',
        'yokohama' => 'yokohama',
        'you' => 'you',
        'youtube' => 'youtube',
        'yt' => 'yt',
        'yun' => 'yun',
        'za' => 'za',
        'zappos' => 'zappos',
        'zara' => 'zara',
        'zero' => 'zero',
        'zip' => 'zip',
        'zippo' => 'zippo',
        'zm' => 'zm',
        'zone' => 'zone',
        'zuerich' => 'zuerich',
        'zw' => 'zw',
    ];

    /**
     * Cached Property
     *
     * @var Collection
     */
    private static $cached;

    /**
     * @var string|null
     */
    protected $file_tld = 'Data/tlds-alpha-by-domain.txt';

    /**
     * @var bool
     */
    protected static $renewed = false;

    /**
     * @var array
     */
    protected static $must_be_ascii = [
        'com', 'org', 'net', 'info', 'me', 'id', 'us',
        'top', 'pw', 'rocks', 'my', 'sg', 'gov', 'google',
        'tk', 'ml', 'gmail', 'comcast', 'abc', 'xyz',
        'ups','sydney', 'au', 'bbc',
    ];

    /**
     * DomainMail constructor.
     */
    public function __construct()
    {
        $this->file_tld = is_dir(__DIR__ .'/Data')
            ? __DIR__ . '/Data/tlds-alpha-by-domain.txt'
            : null;
        !self::$cached && self::$cached =  new Collection();
        $this->renewData();
    }

    /**
     * @param bool $force
     * @return bool
     */
    public function renewData($force = false)
    {
        $result = false;
        $allow_write = false;
        if ($this->file_tld && is_dir(dirname($this->file_tld))
            && is_writable(dirname($this->file_tld))
        ) {
            $allow_write = ! file_exists($this->file_tld)
                ? true
                : is_writable($this->file_tld);
        }

        if ($allow_write) {
            if ($force
                || ! file_exists($this->file_tld)
                || filemtime($this->file_tld) < @strtotime('-2 week')
            ) {
                try {
                    $body = Transport::get(self::TLD_URL)->getResponseBody();
                    if ($body->getSize() > 1024) {
                        $result = @file_put_contents($this->file_tld, (string) $body);
                    }
                } catch (\Exception $err) {
                }
            }
        }
        if (!self::$renewed) {
            self::$renewed = true;
            if ($this->file_tld && is_file($this->file_tld) && is_readable($this->file_tld)) {
                foreach (file($this->file_tld) as $value) {
                    $value = trim($value);
                    if (!$value || $value[0] == '#') {
                        continue;
                    }
                    $value = \strtolower($value);
                    if (isset(self::$tld[$value]) || \strpos($value, ' ') !== false) {
                        continue;
                    }
                    if (($idn_pos = \strpos($value, 'xn-')) !== false) {
                        if ($idn_pos === 0) {
                            $idn = static::idnToUTF8($value);
                            if ($idn !== $value) {
                                $transport[$value] = $idn;
                            }
                        }
                        continue;
                    }
                    self::$tld[$value] = $value;
                }
            }
            ksort(self::$tld, SORT_ASC);
        }

        return $result;
    }

    /**
     * Search Extension
     *
     * @param string $ext
     *
     * @return bool|mixed
     */
    public static function findByExtension($ext)
    {
        if (!is_string($ext)) {
            return false;
        }

        // extension is more than two and less than 19 (max 18)
        if (static::strlen($ext) > 18 || static::strlen($ext) < 2) {
            return false;
        }

        $ext = static::toLowerCase($ext);
        return array_search($ext, self::getAllTld());
    }

    /**
     * @param string $ext
     *
     * @return bool|mixed
     */
    public static function findByExtensionFrom($ext)
    {
        if (!is_string($ext)) {
            return false;
        }
        // extension is more than two and less than 24 (max 18 for utf and 24 of idn)
        if (static::strlen($ext) > 24 || static::strlen($ext) < 2) {
            return false;
        }
        $ext = static::toLowerCase($ext);
        if (strpos($ext, '--') === false) {
            // convert into idn ascii xn-- if possible
            $ext = static::idnToASCII($ext);
        }

        return $ext && isset(self::$tld[$ext]) ? self::$tld[$ext] : false;
    }

    /**
     * Split domain name
     *
     * @param string $domainName
     *
     * @return array|bool
     */
    public static function split($domainName)
    {
        if (!is_string($domainName) || strpos($domainName, '.') === false || trim($domainName) === '') {
            return false;
        }
        // if contain empty characters
        if (preg_match('/[\s]/', $domainName)) {
            return false;
        }

        /**
         * cached
         */
        if (self::$cached->has($domainName)) {
            return self::$cached->get($domainName);
        }

        // does not allow naming more than 255 characters
        if (static::strlen($domainName) > 255) {
            self::$cached->set($domainName, false);
            return false;
        }
        // default
        $retVal = [
            self::SUB_DOMAIN_SELECTOR => '',
            self::DOMAIN_SELECTOR => '',
            self::EXTENSION_SELECTOR => '',
        ];
        $explode = explode('.', $domainName);
        // to lower case
        $retVal[self::EXTENSION_SELECTOR] = static::toLowerCase(end($explode));
        if (static::strlen($retVal[self::EXTENSION_SELECTOR]) < 2
            || static::strlen($retVal[self::EXTENSION_SELECTOR]) > 18
            // must not be a special characters
            || preg_match(
                '/[\~\!\@\#\$\%\^\&\*\(\)\_\+\`\-\=\\\\|\'\{\}\[\]\;\"\:\,\/\<\>\?\s]/',
                $retVal[self::DOMAIN_SELECTOR]
            ) !== 0
        ) {
            self::$cached->set($domainName, false);
            return false;
        }
        array_pop($explode);
        $retVal[self::DOMAIN_SELECTOR] = static::toLowerCase(end($explode));
        array_pop($explode);
        /**
         * minimum domain name must be 1 & max is 63
         */
        if (strlen($retVal[self::DOMAIN_SELECTOR]) < 1 // min 1 character
            // max 64 length chars
            || strlen($retVal[self::DOMAIN_SELECTOR]) > 63
            /**
             * does not allowed start or end with dash
             * @see http://tools.ietf.org/html/rfc1035
             * browse like IE (Internet Explorer) maybe warn if have some or an underscore contains of sub domain
             */
            || substr($retVal[self::DOMAIN_SELECTOR], 0, 1) == '-'
            || substr($retVal[self::DOMAIN_SELECTOR], -1) == '-'
            /**
             * if got match not valid character
             * must not be a special characters
             * allow dash
             */
            || preg_match(
                '/[\~\!\@\#\$\%\^\&\*\(\)\_\+\`\=\\\\|\'\{\}\[\]\;\"\:\,\/\<\>\?\s]/',
                $retVal[self::DOMAIN_SELECTOR]
            ) !== 0
        ) {
            self::$cached->set($domainName, false);
            return false;
        }
        if (count($explode) > 0) {
            $retVal[self::SUB_DOMAIN_SELECTOR] = implode('.', $explode);
            if (mb_strlen($retVal[self::SUB_DOMAIN_SELECTOR], 'UTF-8') < 1
                /**
                 * does not allowed start or end with dash
                 * @see http://tools.ietf.org/html/rfc1035
                 */
                || substr($retVal[self::DOMAIN_SELECTOR], 0, 1) == '-'
                || substr($retVal[self::DOMAIN_SELECTOR], -1) == '-'
                || strpos('..', $retVal[self::SUB_DOMAIN_SELECTOR]) !== false
                // if got match not valid character
                // must not be a special characters
                // sub domain allowed underscore and dash ([_-])
                || preg_match(
                    '/[\~\!\@\#\$\%\^\&\*\(\)\+\`\=\\\\|\'\{\}\[\]\;\"\:\,\/\<\>\?\s]/',
                    $retVal[self::SUB_DOMAIN_SELECTOR]
                ) !== 0
            ) {
                self::$cached->set($domainName, false);
                return false;
            }
        }

        // set cached
        self::$cached->set($domainName, $retVal);
        return $retVal;
    }

    /**
     * Split domain that domain must be utf8
     *
     * @param string $domainName
     *
     * @return array|bool
     */
    public function splitThatASCII($domainName)
    {
        $retVal = static::split($domainName);
        if (empty($retVal)) {
            return false;
        }

        if (!preg_match('/[^a-z]/i', $retVal[self::EXTENSION_SELECTOR])) {
            if ((
                    in_array($retVal[self::EXTENSION_SELECTOR], static::$must_be_ascii)
                    || \strlen($retVal[self::EXTENSION_SELECTOR]) > 3
                )
                && (
                    // sub domain contains not valid character ascii
                    preg_match(
                        '/[^a-z0-9\_\-\.]/i',
                        $retVal[self::SUB_DOMAIN_SELECTOR]
                    )
                    // sub domain contains not valid character ascii
                    || preg_match(
                        '/[^a-z0-9\-]/i',
                        $retVal[self::DOMAIN_SELECTOR]
                    )
                )
            ) {
                return false;
            }
        }

        return $retVal;
    }

    /**
     * @param string $domainName
     * @return array|bool
     */
    public static function getDomainFromExistencesArray($domainName)
    {
        $domain_detail = static::split($domainName);
        if (!$domain_detail) {
            return false;
        }
        $ext = $domain_detail[self::EXTENSION_SELECTOR];
        if (($ext = static::findByExtensionFrom($ext)) === false) {
            return false;
        }

        // ws allow special characters
        if ((in_array($ext, static::$must_be_ascii)
                || !preg_match('/([^a-z])/', $ext) && \strlen($ext) > 3
            )
            && ! preg_match('/([^a-z])/', $domain_detail[self::DOMAIN_SELECTOR])
        ) {
            if ($domain_detail[self::SUB_DOMAIN_SELECTOR] == '') {
                unset($domain_detail[self::SUB_DOMAIN_SELECTOR]);
            }
            return static::splitThatASCII(implode('.', $domain_detail));
        } else {
            return $domain_detail;
        }
    }

    /**
     * validate if is valid Domainname
     *
     * @param string $domainName
     *
     * @return bool
     */
    public static function isValidDomain($domainName)
    {
        $domain = static::getDomainFromExistencesArray($domainName);
        return !empty($domain[self::DOMAIN_SELECTOR]) && trim($domain[self::SUB_DOMAIN_SELECTOR]) == '' ? true : false;
    }

    /**
     * validate if is valid domain name with sub domain
     *
     * @param string $domainName
     *
     * @return bool
     */
    public static function isValidDomainOrSubDomain($domainName)
    {
        $domain = static::getDomainFromExistencesArray($domainName);
        return !empty($domain[self::DOMAIN_SELECTOR]) ? true : false;
    }

    /**
     * Check email and returning valid email if possible
     *
     * @param string $email
     * @param bool   $allow_sub_domain allowed subdomain , this recommended to set into true
     *                                sub domains is allowed for validate domain
     *
     * @return bool|string boolean false if not valid
     */
    public static function mailCheck($email, $allow_sub_domain = true)
    {
        if (!is_string($email) || strpos($email, '@') === false || strlen($email) < 6) {
            return false;
        }

        $data = explode('@', $email);
        // validate must be 2 counted
        if (count($data) <> 2) {
            return false;
        }
        $domain       = $data[1];
        $mail_address = $data[0];
        /**
         * maximum length of email is 254
         * @see https://en.wikipedia.org/wiki/Email_address
         */
        if (static::strlen($mail_address) > 254 || static::strlen($mail_address) < 1
            || strpos('..', $mail_address) !== false
            || in_array(substr($mail_address, 0, 1), ['-', '.', '-']) // does not allowed started with [_-.]
            || in_array(substr($mail_address, -1), ['-', '.', '-']) // does not allowed end with [_-.]
        ) {
            return false;
        }

        $domain_array = static::getDomainFromExistencesArray($domain);
        if (empty($domain_array)
            || $allow_sub_domain === false && trim($domain_array[self::SUB_DOMAIN_SELECTOR]) !== ''
        ) {
            return false;
        }

        // validate mail
        if (preg_match('/[\~\!\@\#\$\%\^\&\*\(\)\+\`\=\\\\|\'\{\}\[\]\;\"\:\,\/\<\>\?\s]/', $mail_address)) {
            return false;
        }

        /**
         * Check common name
         */
        if (in_array(
            $domain_array[self::EXTENSION_SELECTOR],
            ['com', 'net', 'co', 'de', 'jp', 'ca', 'org', 'me']
        )
        ) {
            $common = self::checkCommonEmail($domain_array[self::DOMAIN_SELECTOR], $email);
            if ($common !== true) {
                return $common;
            }
        }
        if ($domain_array[self::DOMAIN_SELECTOR] == 'co'
            && in_array(
                $domain_array[self::EXTENSION_SELECTOR],
                // available sub domain
                [
                    'uk', 'id', 'sg', 'jp', 'in',
                ]
            )
        ) {
            $subDomain = explode('.', $domain_array[self::SUB_DOMAIN_SELECTOR]);
            $sub_domain_name = end($subDomain);
            if (count($subDomain) > 1
                && in_array(
                    $sub_domain_name,
                    [
                        'gmail',
                        'googlemail',
                        'google',
                        'hotmail',
                        'outlook',
                        'live',
                        'ymail',
                        'yahoo',
                        'yahoomail',
                        'rocketmail',
                        'mail'
                    ]
                )
            ) {
                return false;
            }
            $common = self::checkCommonEmail($sub_domain_name, $email);
            if ($common !== true) {
                return $common;
            }
        }
        if (! in_array($domain_array[self::EXTENSION_SELECTOR], ["ws", "jp", "cn", "ca", "fr", "ar"])
            && ! preg_match('/[^a-z]/i', $domain_array[self::EXTENSION_SELECTOR])
            && preg_match('/[^0-9a-z\_\-\.]/i', $mail_address)
            // dot dev is local development
            || $domain_array[self::EXTENSION_SELECTOR] == 'dev'
        ) {
            return false;
        }

        if ($domain_array[self::SUB_DOMAIN_SELECTOR] == '') {
            unset($domain_array[self::SUB_DOMAIN_SELECTOR]);
        }
        return static::toLowerCase($mail_address) . '@' . implode('.', $domain_array);
    }

    /**
     * Check common mail
     *
     * @param string $domain
     * @param string $email
     * @access private
     *
     * @return bool|string
     */
    private static function checkCommonEmail($domain, $email)
    {
        $data = explode('@', $email);
        $mail_address = $data[0];
        switch ($domain) {
            case 'gmail':
            case 'googlemail':
            case 'google':
                if (strlen($mail_address) > 30
                    || preg_match('/[^a-z0-9\.]/i', $mail_address)
                    || ! preg_match('/[a-z0-9\.]{1,30}[a-z]{1}/i', $mail_address)
                ) {
                    return false;
                }
                return static::toLowerCase($email);
                break;
            case 'yahoo':
            case 'yahoomail':
            case 'ymail':
            case 'rocketmail':
                if (strlen($mail_address) > 32
                    || substr_count($mail_address, '.') > 1
                    || substr_count($mail_address, '_') > 1
                    || preg_match('/[^a-z0-9\.\_]/i', $mail_address)
                    || ! preg_match('/[a-z0-9\.]{1,30}[a-z]{1}/i', $mail_address)) {
                    return false;
                }
                return static::toLowerCase($email);
                break;
            case 'live':
            case 'hotmail':
            case 'outlook':
                if (preg_match('/[a-z0-9\.\_\-]/i', $mail_address)
                    || !preg_match('/[a-z0-9\.\_\-]{1,30}[a-z]{1/i', $mail_address)
                ) {
                    return false;
                }
                return static::toLowerCase($email);
                break;
        }
        return true;
    }

    /**
     * Check email allowed only alphabetic
     *  this method suitable for determine really valid email address
     *
     * @param string $email
     *
     * @return bool|string boolean false if not valid
     */
    public function emailAlphabetic($email)
    {
        if (!is_string($email) || strpos($email, '@') === false || strlen($email) < 6) {
            return false;
        }

        $data = explode('@', $email);
        // validate must be 2 counted
        if (count($data) <> 2) {
            return false;
        }
        $mail_address = $data[0];
        /**
         * maximum length of email is 254
         * @see https://en.wikipedia.org/wiki/Email_address
         */
        if (static::strlen($mail_address) > 254 || static::strlen($mail_address) < 1
            || strpos('..', $mail_address) !== false
            || in_array(substr($mail_address, 0, 1), ['-', '.', '-']) // does not allowed started with [_-.]
        ) {
            return false;
        }

        if (preg_match('/[^a-z0-9\_\-\.]/', $mail_address)) {
            return false;
        }

        return static::mailCheck($email);
    }

    /**
     * Get all tlds list
     *
     * @return array
     */
    public static function getAllTld()
    {
        return self::$tld;
    }

    /**
     * bring it into lower case with mbstring all alphabetic characters
     * @see http://php.net/manual/en/function.mb-strtolower.php
     *
     * @param string $string
     *
     * @return string
     */
    public static function toLowerCase($string)
    {
        if (!is_string($string)) {
            return $string;
        }
        static $exist;
        if (!isset($exist)) {
            $exist = function_exists('\mb_strtolower');
        }

        return $exist
            ? \mb_strtolower($string, 'UTF-8')
            : \strtolower($string);
    }

    /**
     * Calculate length
     *
     * @see http://php.net/manual/en/function.mb-strlen.php
     *
     * @param string $string
     *
     * @return integer
     */
    public static function strlen($string)
    {
        if (!is_string($string)) {
            return null;
        }
        static $exist;
        if (!isset($exist)) {
            $exist = function_exists('\mb_strlen');
        }

        return $exist
            ? mb_strlen($string, 'UTF-8')
            : \strlen($string);
    }

    /**
     * @param string $input
     * @return string
     */
    public static function idnToUTF8($input)
    {
        static $exist;
        if (!isset($exist)) {
            $exist = function_exists('\idn_to_utf8');
        }
        if (!is_string($input) || trim($input) == '') {
            return '';
        }

        return $exist ? \idn_to_utf8($input) : $input;
    }

    /**
     * @param string $input
     * @return string
     */
    public static function idnToASCII($input)
    {
        static $exist;
        if (!isset($exist)) {
            $exist = function_exists('\idn_to_ascii');
        }
        if (!is_string($input) || trim($input) == '') {
            return '';
        }

        return $exist ? \idn_to_ascii($input) : $input;
    }
}

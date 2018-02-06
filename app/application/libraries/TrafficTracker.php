<?php

class TrafficTracker
{
//    protected $_apiUrl = "http://www.geoplugin.net/json.gp?ip=";
    protected $_apiUrl = "https://freegeoip.net/json/";
    protected $_ip;
    protected $_country;
    protected $_state;
    protected $_device;
    protected $_os;
    protected $_browser;
    protected $_referer;
    protected $_context;

    public function getIp()
    {
        return $this->_ip;
    }

    public function setIp()
    {
        // Variables locales
        $ip = null;

        // Identificando Ip dependiendo de las variables del browser
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            if (isset( $_SERVER ['HTTP_VIA'] )) {
                $ip = $_SERVER ['HTTP_VIA'];
            } else {
                if (isset( $_SERVER ['REMOTE_ADDR'] )) {
                    $ip = $_SERVER ['REMOTE_ADDR'];
                }
            }
        }

        $this->_ip = $ip;
    }

    public function getCountry()
    {
        return $this->_country;
    }

    public function setCountry($ip)
    {
        require_once APP . '/model/TrafficTrackerModel.php';
        // Variables locales
        $country = null;

        // Identificando la Geolocalización
        $result = TrafficTrackerModel::getTrackerCountry($ip);

        if (!$result) {
            $geoDataResult = $this->getGeoDataInfo($ip);
//            $countryName = $geoDataResult['geoplugin_countryName'];
            $countryName = $geoDataResult['country_name'];

            $country = $countryName ? $countryName : 'OTRO';
        } else {
            $country = $result;
        }

        $this->_country = $country;
    }

    public function getState()
    {
        return $this->_state;
    }

    public function setState($ip)
    {
        require_once APP . '/model/TrafficTrackerModel.php';
        // Variables locales
        $state = null;

        // Identificando la Geolocalización
        $result = TrafficTrackerModel::getTrackerState($ip);

        if (!$result) {
            $geoDataResult = $this->getGeoDataInfo($ip);
//            $stateName = $geoDataResult['geoplugin_regionName'];
            $stateName = $geoDataResult['region_name'];

            $state = $stateName ? $stateName : 'OTRO';
        } else {
            $state = $result;
        }

        $this->_state = $state;
    }

    public function getDevice()
    {
        return $this->_device;
    }

    public function setDevice()
    {
        // Variables locales
        $device   = "";
        $tabletDevice = 0;
        $movilDevice = 0;

        // Identificando si es una Tablet
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tabletDevice++;
        }

        // Identificando si es un Smartphone con HTTP_USER_AGENT
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $movilDevice++;
        }

        // Identificando si es un Smartphone con HTTP_ACCEPT, HTTP_X_WAP_PROFILE ó HTTP_PROFILE
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $movilDevice++;
        }

        // Identificando si es un Smartphone a través de los tipos de Agentes
        $mobileUserAgent = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobileAgentType = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');

        if (in_array($mobileUserAgent,$mobileAgentType)) {
            $movilDevice++;
        }

        // Identificando el tipo de dispositivo en el caso de Opera
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
            $movilDevice++;
            $sDeviceUserAgent = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $sDeviceUserAgent)) {
                $tabletDevice++;
            }
        }

        // Determinando tipo de dispositivo
        if ($tabletDevice > 0) {
           $device = "TABLET";
        } else {
            if ($movilDevice > 0) {
                $device = "SMARTPHONE";
            } else {
                $device = "ESCRITORIO";
            }
        }

        $this->_device = $device;
    }

    public function getOs()
    {
        return $this->_os;
    }

    public function setOs()
    {
        // Variables locales
        $os   = null;
        $osLocate = false;

        // Asegurando la existencia de la variable global
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            // Identificando Windows
            if ((strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),"WIN")) && (!$osLocate) ){
                $os = "WINDOWS";
                $osLocate = true;
            }

            // Identificando Android
            if ((strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),"ANDROID")) && (!$osLocate) ){
                $os = "ANDROID";
                $osLocate = true;
            }

            // Identificando Linux
            if ((strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),"LINUX")) && (!$osLocate) ){
                $os = "LINUX";
                $osLocate = true;
            }

            // Identificando Mac
            if ((strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),"MAC")) && (!$osLocate) ){
                $os = "MAC";
                $osLocate = true;
            }

            // Identificando IOS
            if (((strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),"IPAD")) || (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),"IPHONE"))) && (!$osLocate) ){
                $os = "IOS";
                $osLocate = true;
            }
        }

        $this->_os = $os;
    }

    public function getBrowser()
    {
        return $this->_browser;
    }

    public function setBrowser()
    {
        // Variables locales
        $browser = "OTRO";

        // Identificando el navegador y sus variantes
        if (preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/Opera/i', $_SERVER['HTTP_USER_AGENT'])) {
            $browser = 'INTERNET EXPLORER';
        } elseif (preg_match('/trident/i', $_SERVER['HTTP_USER_AGENT'])) {
            $browser = 'INTERNET EXPLORER';
        } elseif (preg_match('/Firefox/i', $_SERVER['HTTP_USER_AGENT'])) {
            $browser = 'MOZILLA FIREFOX';
        } elseif (preg_match('/Chrome/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/OPR/i', $_SERVER['HTTP_USER_AGENT'])) {
            $browser = 'GOOGLE CHROME';
        } elseif (preg_match('/Safari/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/Android/i', $_SERVER['HTTP_USER_AGENT'])) {
            $browser = 'APPLE SAFARI';
        } elseif (preg_match('/Opera/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/OPR/i', $_SERVER['HTTP_USER_AGENT'])) {
            $browser = 'OPERA';
        } elseif (preg_match('/Netscape/i', $_SERVER['HTTP_USER_AGENT'])) {
            $browser = 'NETSCAPE';
        }

        $this->_browser = $browser;
    }

    public function getReferer()
    {
        return $this->_referer;
    }

    public function setReferer()
    {
        // Variables locales
        $referer = 'PROCADIST';

        // Identificando sitio de referencia
        if (isset($_SERVER['HTTP_REFERER'])) {
            // $referer = explode('/', $_SERVER['HTTP_REFERER']);
            // $referer = $referer[0] . "//" . $referer[2];
            $referer = $_SERVER['HTTP_REFERER'];
        }

        $this->_referer = $referer;
    }

    public function getContext()
    {
        return $this->_context;
    }

    public function setContext()
    {
        $context = null;

        if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['SERVER_NAME'])) {
            $context = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }

        $this->_context = $context;
    }

    private function getGeoDataInfo($ip = null)
    {
        $geoData = json_decode(file_get_contents($this->_apiUrl . $ip), true);

        return $geoData;
    }

    public function setAll()
    {
        $this->setIp();
        $this->setCountry($this->_ip);
        $this->setState($this->_ip);
        $this->setDevice();
        $this->setBrowser();
        $this->setReferer();
        $this->setOs();
        $this->setContext();
    }

    public function getAll()
    {
        return array(
            'ip'      => $this->getIp(),
            'country' => strtoupper($this->getCountry()),
            'state'   => strtoupper($this->getState()),
            'device'  => $this->getDevice(),
            'browser' => $this->getBrowser(),
            'referer' => $this->getReferer(),
            'os'      => $this->getOs(),
            'context' =>$this->getContext()
        );
    }
}

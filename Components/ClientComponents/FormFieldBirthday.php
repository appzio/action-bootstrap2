<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait FormFieldBirthday {

    /**
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'hint' => 'hint text',
     * 'height' => '40',
     * 'submit_menu_id' => 'someid',
     * 'maxlength', => '80',
     * 'input_type' => 'text',
     * 'activation' => 'initially' //initially or keep-open,
     * 'empty' => '1'       // whether the field should be empty and not use submitted value
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */
    public function getComponentFormFieldBirthday(array $parameters=array(),array $styles=array()){
        /** @var BootstrapView $this */

        $years = '1910;1910;1911;1911;1912;1912;1913;1913;1914;1914;1915;1915;1916;1916;1917;1917;1918;1918;1919;1919;1920;1920;1921;1921;1922;1922;1923;1923;1924;1924;1925;1925;1926;1926;1927;1927;1928;1928;1929;1929;1930;1930;1931;1931;1932;1932;1933;1933;1934;1934;1935;1935;1936;1936;1937;1937;1938;1938;1939;1939;1940;1940;1941;1941;1942;1942;1943;1943;1944;1944;1945;1945;1946;1946;1947;1947;1948;1948;1949;1949;1950;1950;1951;1951;1952;1952;1953;1953;1954;1954;1955;1955;1956;1956;1957;1957;1958;1958;1959;1959;1960;1960;1961;1961;1962;1962;1963;1963;1964;1964;1965;1965;1966;1966;1967;1967;1968;1968;1969;1969;1970;1970;1971;1971;1972;1972;1973;1973;1974;1974;1975;1975;1976;1976;1977;1977;1978;1978;1979;1979;1980;1980;1981;1981;1982;1982;1983;1983;1984;1984;1985;1985;1986;1986;1987;1987;1988;1988;1989;1989;1990;1990;1991;1991;1992;1992;1993;1993;1994;1994;1995;1995;1996;1996;1997;1997;1998;1998;1999;1999;2000;2000;2001;2001;2002;2002;2003;2003;2004;2004;2005;2005;2006;2006;2007;2007;2008;2008';
        $months = '01;{#month_jan#};02;{#month_feb#};03;{#month_mar#};04;{#month_apr#};05;{#month_may#};06;{#month_jun#};07;{#month_jul#};08;{#month_aug#};09;{#month_sep#};10;{#month_oct#};11;{#month_nov#};12;{#month_dec#}';
        $days = '01;01;02;02;03;03;04;04;05;05;06;06;07;07;08;08;09;09;10;10;11;11;12;12;13;13;14;14;15;15;16;16;17;17;18;18;19;19;20;20;21;21;22;22;23;23;24;24;25;25;26;26;27;27;28;28;29;29;30;30;31;31';

        $yearvalue = $this->model->getSubmittedVariableByName('birth_year') ? $this->model->getSubmittedVariableByName('birth_year') : $this->model->getSavedVariable('birth_year');
        $dayvalue = $this->model->getSubmittedVariableByName('birth_day') ? $this->model->getSubmittedVariableByName('birth_day') : $this->model->getSavedVariable('birth_day');
        $monthvalue = $this->model->getSubmittedVariableByName('birth_month') ? $this->model->getSubmittedVariableByName('birth_month') : $this->model->getSavedVariable('birth_month');

        $var_month = $this->model->getVariableId('birth_month');
        $var_day = $this->model->getVariableId('birth_day');
        $var_year = $this->model->getVariableId('birth_year');

        if(isset($parameters['format']) AND $parameters['format'] == 'us'){
            $col[] = $this->getComponentFormFieldSelectorList($months,array('value' => $monthvalue,'variable' => $var_month),array('width' => 120,'margin' => '0 10 0 0','font-size' => 16));
            $col[] = $this->getComponentFormFieldSelectorList($days,array('value' => $dayvalue,'variable' => $var_day),array('width' => 50,'margin' => '0 10 0 10','font-size' => 16));
            $col[] = $this->getComponentFormFieldSelectorList($years,array('value' => $yearvalue,'variable' => $var_year),array('width' => 80,'margin' => '0 0 0 0','font-size' => 16));
        } else {
            $col[] = $this->getComponentFormFieldSelectorList($days,array('value' => $dayvalue,'variable' => $var_day),array('width' => 50,'margin' => '0 10 0 0','font-size' => 16));
            $col[] = $this->getComponentFormFieldSelectorList($months,array('value' => $monthvalue,'variable' => $var_month),array('width' => 150,'margin' => '0 10 0 0','font-size' => 16));
            $col[] = $this->getComponentFormFieldSelectorList($years,array('value' => $yearvalue,'variable' => $var_year),array('width' => 80,'margin' => '0 0 0 0','font-size' => 16));

        }

        return $this->getComponentRow($col,array(),array('margin' => '0 40 0 40'));
    }
}
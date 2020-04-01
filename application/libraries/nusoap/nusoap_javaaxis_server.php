<?php
class nusoap_javaaxis_server extends nusoap_server
{
        function serialize_val ($val, $name=false, $type=false, $name_ns=false, $type_ns=false, $attributes=false, $use='encoded', $soapval=false)
        {
                if (($this->request) && (preg_match("/<multiRef/i", $this->request)) &&
                    (is_array($val)) && ("arrayStruct" === $this->isArraySimpleOrStruct($val))) {
                        $type = "Map";
                        $type_ns = "http://xml.apache.org/xml-soap";
                }

                return parent::serialize_val($val, $name, $type, $name_ns, $type_ns, $attributes, $use, $soapval);
        }
}
?>
<?php

namespace App\Http\Controllers;

use App\Services\PizzaSOAPService;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\Request;
use SoapServer;

class SOAPController extends Controller
{
    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

    /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    public function handle(Request $request)
    {
        $server = new SoapServer(null, [
            'uri' => 'http://localhost:8080/soap'
        ]);

        $server->setClass(PizzaSOAPService::class);

        ob_start();
        $server->handle();
        $response = ob_get_clean();

        return response($response, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function wsdl()
    {
        $wsdl = $this->generateWSDL();
        return response($wsdl, 200)
            ->header('Content-Type', 'text/xml');
    }

    private function generateWSDL()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://schemas.xmlsoap.org/wsdl/"
             xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
             xmlns:xsd="http://www.w3.org/2001/XMLSchema"
             xmlns:tns="http://localhost:8000/soap"
             targetNamespace="http://localhost:8000/soap">

    <types>
        <xsd:schema targetNamespace="http://localhost:8000/soap">
            <!-- Category Type -->
            <xsd:complexType name="Category">
                <xsd:sequence>
                    <xsd:element name="id" type="xsd:integer"/>
                    <xsd:element name="cname" type="xsd:string"/>
                    <xsd:element name="price" type="xsd:integer"/>
                </xsd:sequence>
            </xsd:complexType>

            <!-- Pizza Type -->
            <xsd:complexType name="Pizza">
                <xsd:sequence>
                    <xsd:element name="id" type="xsd:integer"/>
                    <xsd:element name="pname" type="xsd:string"/>
                    <xsd:element name="category_name" type="xsd:string"/>
                    <xsd:element name="vegetarian" type="xsd:boolean"/>
                </xsd:sequence>
            </xsd:complexType>

            <!-- Order Type -->
            <xsd:complexType name="Order">
                <xsd:sequence>
                    <xsd:element name="id" type="xsd:integer"/>
                    <xsd:element name="user_id" type="xsd:integer"/>
                    <xsd:element name="pizza_id" type="xsd:integer"/>
                    <xsd:element name="quantity" type="xsd:integer"/>
                    <xsd:element name="address" type="xsd:string"/>
                    <xsd:element name="notes" type="xsd:string"/>
                    <xsd:element name="status" type="xsd:string"/>
                    <xsd:element name="total_price" type="xsd:decimal"/>
                </xsd:sequence>
            </xsd:complexType>
        </xsd:schema>
    </types>

    <!-- Messages -->
    <message name="getCategoriesRequest"/>
    <message name="getCategoriesResponse">
        <part name="categories" type="tns:Category"/>
    </message>

    <message name="createCategoryRequest">
        <part name="cname" type="xsd:string"/>
        <part name="price" type="xsd:integer"/>
    </message>
    <message name="createCategoryResponse">
        <part name="category" type="tns:Category"/>
    </message>

    <!-- Port Type -->
    <portType name="PizzaServicePortType">
        <operation name="getCategories">
            <input message="tns:getCategoriesRequest"/>
            <output message="tns:getCategoriesResponse"/>
        </operation>
        <operation name="createCategory">
            <input message="tns:createCategoryRequest"/>
            <output message="tns:createCategoryResponse"/>
        </operation>

    </portType>

    <!-- Binding -->
    <binding name="PizzaServiceBinding" type="tns:PizzaServicePortType">
        <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>
        <operation name="getCategories">
            <soap:operation soapAction="http://localhost:8000/soap/getCategories"/>
            <input>
                <soap:body use="encoded" namespace="http://localhost:8000/soap"
                          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
            </input>
            <output>
                <soap:body use="encoded" namespace="http://localhost:8000/soap"
                          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
            </output>
        </operation>
    </binding>

    <!-- Service -->
    <service name="PizzaService">
        <port name="PizzaServicePort" binding="tns:PizzaServiceBinding">
            <soap:address location="http://localhost:8000/soap"/>
        </port>
    </service>

</definitions>';
    }
}

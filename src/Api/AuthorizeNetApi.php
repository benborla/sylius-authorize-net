<?php
declare(strict_types=1);

namespace BenBorla\AuthorizeNetPlugin\Api;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

final class AuthorizeNetApi
{
    protected $api;

    /**
     * @var AnetAPI\MerchantAuthenticationType
     */
    protected $auth;

    /**
     * @var AnetAPI\CreditCardType
     */
    protected $creditCard;

    /**
     * @var AnetAPI\CustomerAddressType
     */
    protected $customerAddress;

    /**
     * @var AnetAPI\CustomerDataType
     */
    protected $customerData;

    /**
     * @param string $loginId
     * @param string $transactionKey
     * @param bool $sandbox
     * @return void
     */
    public function authorize(string $loginId, string $transactionKey)
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($loginId);
        $merchantAuthentication->setTransactionKey($transactionKey);

        $this->auth = $merchantAuthentication;

        return $this->auth;
    }

    /**
     * @param int $cardNumber
     * @param string $expiry
     * @param int $cvv
     * @return AnetAPI\CreditCardType
     */
    public function setCreditCard(int $cardNumber, string $expiry, int $cvv)
    {
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expiry);
        $creditCard->setCardCode($cvv);

        $this->creditCard = $creditCard;

        return $this->creditCard;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $company
     * @param string $address
     * @param string $city
     * @param string $state
     * @param string $zip
     * @param string $country
     * @return void
     */
    public function setBillToAddress(
        string $firstName,
        string $lastName,
        string $company = null,
        string $address,
        string $city,
        string $state,
        string $zip,
        string $country = 'USA'
    ) {
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($firstName);
        $customerAddress->setLastName($lastName);
        $customerAddress->setCompany($company);
        $customerAddress->setAddress($address);
        $customerAddress->setCity($city);
        $customerAddress->setState($state);
        $customerAddress->setZip($zip);
        $customerAddress->setCountry($country);

        $this->customerAddress = $customerAddress;

        return $customerAddress;
    }

    /**
     * @param int $id
     * @param string $email
     * @param string $type
     * @return void
     */
    public function setCustomerIdentity(int $id, string $email, string $type = 'individual')
    {
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType($type);
        $customerData->setId($id);
        $customerData->setEmail($email);

        $this->customerData = $customerData;

        return $this->customerData;
    }

    // https://github.com/AuthorizeNet/sample-code-php/blob/master/PaymentTransactions/charge-credit-card.php#L48
    // @todo create Transaction
}

<?php

namespace App\Utils\Objects\User\Mock;

use JMS\Serializer\Annotation\Type;

class UserData
{

    /**
     * @Type("string")
     * @var string
     */
    private $uid;

    /**
     * @Type("string")
     * @var string
     */
    private $username;

    /**
     * @Type("string")
     * @var string|null
     */
    private $password;

    /**
     * @Type("string")
     * @var string|null
     */
    private $name;

    /**
     * @Type("string")
     * @var string|null
     */
    private $surname;

    /**
     * @Type("string")
     * @var string|null
     */
    private $company;

    /**
     * @Type("string")
     * @var string|null
     */
    private $gender;

    /**
     * @Type("string")
     * @var string|null
     */
    private $fiscalCode;

    /**
     * @Type("string")
     * @var string|null
     */
    private $email;

    /**
     * @Type("string")
     * @var string|null
     */
    private $phone;

    /**
     * @Type("string")
     * @var string|null
     */
    private $mobile;

    /**
     * @Type("string")
     * @var string|null
     */
    private $birthPlace;

    /**
     * @Type("string")
     * @var string|null
     */
    private $birthDate;

    /**
     * @Type("string")
     * @var string|null
     */
    private $street;

    /**
     * @Type("string")
     * @var string|null
     */
    private $zipcode;

    /**
     * @Type("string")
     * @var string|null
     */
    private $city;

    /**
     * @Type("string")
     * @var string|null
     */
    private $regionCode;

    /**
     * @Type("string")
     * @var string|null
     */
    private $countryCode;

    /**
     * @Type("string")
     * @var string|null
     */
    private $fl_active;

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     * @return UserData
     */
    public function setUid(string $uid): UserData
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return UserData
     */
    public function setUsername(string $username): UserData
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return UserData
     */
    public function setPassword(?string $password): UserData
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return UserData
     */
    public function setName(?string $name): UserData
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     * @return UserData
     */
    public function setSurname(?string $surname): UserData
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     * @return UserData
     */
    public function setCompany(?string $company): UserData
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     * @return UserData
     */
    public function setGender(?string $gender): UserData
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFiscalCode(): ?string
    {
        return $this->fiscalCode;
    }

    /**
     * @param string|null $fiscalCode
     * @return UserData
     */
    public function setFiscalCode(?string $fiscalCode): UserData
    {
        $this->fiscalCode = $fiscalCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return UserData
     */
    public function setEmail(?string $email): UserData
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return UserData
     */
    public function setPhone(?string $phone): UserData
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string|null $mobile
     * @return UserData
     */
    public function setMobile(?string $mobile): UserData
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    /**
     * @param string|null $birthPlace
     * @return UserData
     */
    public function setBirthPlace(?string $birthPlace): UserData
    {
        $this->birthPlace = $birthPlace;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * @param string|null $birthDate
     * @return UserData
     */
    public function setBirthDate(?string $birthDate): UserData
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     * @return UserData
     */
    public function setStreet(?string $street): UserData
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * @param string|null $zipcode
     * @return UserData
     */
    public function setZipcode(?string $zipcode): UserData
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return UserData
     */
    public function setCity(?string $city): UserData
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegionCode(): ?string
    {
        return $this->regionCode;
    }

    /**
     * @param string|null $regionCode
     * @return UserData
     */
    public function setRegionCode(?string $regionCode): UserData
    {
        $this->regionCode = $regionCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     * @return UserData
     */
    public function setCountryCode(?string $countryCode): UserData
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFlActive(): ?string
    {
        return $this->fl_active;
    }

    /**
     * @param string|null $fl_active
     * @return UserData
     */
    public function setFlActive(?string $fl_active): UserData
    {
        $this->fl_active = $fl_active;
        return $this;
    }

}
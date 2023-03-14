<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column(length: 255)]
    private ?string $date_pay = null;

    #[ORM\Column]
    private ?int $payment_method = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company_pay = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getDatePay(): ?string
    {
        return $this->date_pay;
    }

    public function setDatePay(string $date_pay): self
    {
        $this->date_pay = $date_pay;

        return $this;
    }

    public function getPaymentMethod(): ?int
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(int $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getCompanyPay(): ?string
    {
        return $this->company_pay;
    }

    public function setCompanyPay(?string $company_pay): self
    {
        $this->company_pay = $company_pay;

        return $this;
    }
}

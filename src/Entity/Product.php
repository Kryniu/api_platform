<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'post' => [
            'path' => '/product/add',
            'status' => 200,
        ],
        'get' => [
            'path' => '/products_with_category/all',
        ]
    ],
    itemOperations: [
        'get',
    ],
)]
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Name must be at least {{ limit }}",
     *      maxMessage = "Name cannot be longer than {{ limit }}"
     * )
     * @Assert\NotBlank()
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    #[Assert\Regex(
        pattern: '/[A-J]{1}[\d]{3}/',
        message: 'Symbol should look like C300, first letter from A-J'
    )]
    private ?string $symbol;

    /**
     * @ORM\OneToOne(targetEntity=Category::class, inversedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Category $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}

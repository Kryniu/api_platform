<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'post' => [
                'path' => '/categories/add',
                'status' => 200,
            ],
        ],
    itemOperations: [
        'get',
    ],
    attributes: [
        'normalization_context' => ['groups' => ['read']],
        'denormalization_context' => ['groups' => ['write']],
    ]
)]
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=50)
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
     * @ORM\OneToOne(targetEntity=Product::class, mappedBy="category", cascade={"persist", "remove"})
     */
    private ?Product $product;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        if ($product->getCategory() !== $this) {
            $product->setCategory($this);
        }

        $this->product = $product;

        return $this;
    }
}

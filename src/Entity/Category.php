<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Name must be at least {{ limit }}",
     *      maxMessage = "Name cannot be longer than {{ limit }}"
     * )
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, mappedBy="category", cascade={"persist", "remove"})
     */
    private $product;

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

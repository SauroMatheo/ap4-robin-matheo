<?php

namespace App\Entity;

use App\Repository\ImageArticleRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/*
Classe ImageArticle:
Simplement une classe définissant une image pour un article.

?string lienImage:      Lien absolu de la ressource contenant l'image (limité à 255 char)
?Articles lArticle:     Article possèdant l'image
*/
#[ORM\Entity(repositoryClass: ImageArticleRepository::class)]
class ImageArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["articleList"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["articleList"])]
    private ?string $lienImage = null;

    #[ORM\ManyToOne(inversedBy: 'lesImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Articles $lArticle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLienImage(): ?string
    {
        return $this->lienImage;
    }

    public function setLienImage(string $lienImage): static
    {
        $this->lienImage = $lienImage;

        return $this;
    }

    public function getLArticle(): ?Articles
    {
        return $this->lArticle;
    }

    public function setLArticle(?Articles $lArticle): static
    {
        $this->lArticle = $lArticle;

        return $this;
    }
}

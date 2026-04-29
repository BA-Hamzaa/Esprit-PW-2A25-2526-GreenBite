<?php
class Produit {
    private $id          = null;
    private $nom         = null;
    private $description = null;
    private $prix        = null;
    private $stock       = null;
    private $categorie   = null;
    private $image       = null;
    private $producteur  = null;
    private $is_bio      = null;
    private $created_at  = null;

    function __construct($nom, $description, $prix, $stock, $categorie, $image = '', $producteur = '', $is_bio = 0) {
        $this->nom         = $nom;
        $this->description = $description;
        $this->prix        = $prix;
        $this->stock       = $stock;
        $this->categorie   = $categorie;
        $this->image       = $image;
        $this->producteur  = $producteur;
        $this->is_bio      = $is_bio;
    }

    // ==================== GETTERS ====================

    function getId()          { return $this->id; }
    function getNom()         { return $this->nom; }
    function getDescription() { return $this->description; }
    function getPrix()        { return $this->prix; }
    function getStock()       { return $this->stock; }
    function getCategorie()   { return $this->categorie; }
    function getImage()       { return $this->image; }
    function getProducteur()  { return $this->producteur; }
    function getIsBio()       { return $this->is_bio; }
    function getCreatedAt()   { return $this->created_at; }

    // ==================== SETTERS ====================

    function setNom(string $nom)                 { $this->nom = $nom; }
    function setDescription(string $description) { $this->description = $description; }
    function setPrix(float $prix)                { $this->prix = $prix; }
    function setStock(int $stock)                { $this->stock = $stock; }
    function setCategorie(string $categorie)     { $this->categorie = $categorie; }
    function setImage(string $image)             { $this->image = $image; }
    function setProducteur(string $producteur)   { $this->producteur = $producteur; }
    function setIsBio(int $is_bio)               { $this->is_bio = $is_bio; }
}
?>

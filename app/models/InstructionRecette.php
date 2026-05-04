<?php
class InstructionRecette {
    private $id          = null;
    private $recette_id  = null;
    private $ordre       = 1;
    private $titre       = null;
    private $description = null;
    private $created_at  = null;

    function __construct($recette_id, $ordre, $titre, $description) {
        $this->recette_id  = $recette_id;
        $this->ordre       = $ordre;
        $this->titre       = $titre;
        $this->description = $description;
    }

    // ==================== GETTERS ====================
    function getId()          { return $this->id; }
    function getRecetteId()   { return $this->recette_id; }
    function getOrdre()       { return $this->ordre; }
    function getTitre()       { return $this->titre; }
    function getDescription() { return $this->description; }
    function getCreatedAt()   { return $this->created_at; }

    // ==================== SETTERS ====================
    function setRecetteId(int $recette_id)     { $this->recette_id  = $recette_id; }
    function setOrdre(int $ordre)              { $this->ordre       = $ordre; }
    function setTitre(string $titre)           { $this->titre       = $titre; }
    function setDescription(string $desc)      { $this->description = $desc; }
}
?>

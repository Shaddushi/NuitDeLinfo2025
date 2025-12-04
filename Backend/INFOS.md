# Structure du projet

## Controller
Dossier contenant les routes de l'API.

Les routes sont définies comme ceci :
```php
#[Route("/<nom>", name: "<début.nom.route>", methods: ["<liste des méthodes utilisées>"])]
````

## DTO
Les objets renvoyés sous format JSON

## Entity
Les objets liés à la base de données via Doctrine.

Une entité est définie avec son repository :
```php
#[ORM\Entity(repositoryClass: Repository::class)]
```
On peut définir si chaque attribut est un id dans la table,
```php
#[ORM\Id]
```
et les informations par rapport à sa colonne.
```php
#[ORM\Column(type: "string", length: 50, unique: true)]
/**
* [...]
 */
#[ORM\Column(name: "date_creation", type: "datetime", nullable: false)]
```

## Factory
Transforme simplement une entité Doctrine en objet DTO.

## Repository
La classe qui gère les appels à la base de données. Elle transforme ses résultats
en objet(s) PHP grâce à la classe à laquelle elle est liée :
```php
public function __construct(ManagerRegistry $registry) {
	parent::__construct($registry, Entity::class);
	$this->em = $this->getEntityManager();
}
```
On peut faire des appels avec des paramètres
```php
return $this->createQueryBuilder('u')
	->where("u.id = :id")
	->setParameter("id", $id)
	->getQuery()
	->getOneOrNullResult();
```
ou récupérer des listes d'objets
```php
return $this->createQueryBuilder('u')
	->getQuery()
	->getResult();
```

## Service
Interface entre le controller et le repository.
Permet de rendre les choses un peu plus propres en récupérant les paramètres du controller,
récupérant les objets du repository, vérifiant les incohérences et renvoyant un objet DTO propre.

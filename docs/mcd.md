# MCD

Category : une catégorie peut ne peut avoir de produit enregistré et plusieurs au maximum / 0-N
Product : un produit doit être lié au moins à une catégorie et ne peut être lié qu'à une seule catégorie / 1-1

Porteur de la clé étrangère : Product, on est sur une relation ManyToOne


Tag :  un tag peut n'avoir aucune recette liée à lui mais peut en avoir plusieurs au maximum / 0-N
Recipe : une recette doit être liée au minimum à un tag et peut être liée à plusieurs tags / 1-N

Porteur de la clé étrangère : pas de cardinalité maximale chez ni l'un ni l'autre, on est face à une relation ManyToMany donc il va nous falloir une table intermédiaire


```
CATEGORY: category code, category name, subtitle, picture
contains, 0N CATEGORY, 11 PRODUCT
PRODUCT: product code, product name, description, picture, price, status, category_id

RECIPE: recipe code, recipe name, ingredients, steps, duration, source, 
is tagged as, 1N RECIPE, 0N TAG
TAG: tag code, tag name
```
<?php
  
namespace App\Twig;
  
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Repository\NavigationRepository;
  
class NavigationExtension extends AbstractExtension
{
    private $navigationRepository;
    public function __construct(NavigationRepository $navigationRepository)
    {
        $this->navigationRepository = $navigationRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('ItemsNavigations', [$this, 'ItemsNavigationsFunction']),
        ];
    }
  
    public function ItemsNavigationsFunction()
    {
        $tab = $this->navigationRepository->findAll();
        return $tab;
    }
}
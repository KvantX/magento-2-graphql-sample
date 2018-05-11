<?php
declare(strict_types=1);

namespace Hackathon\CatalogGraphQl\Model;

use Magento\Framework\GraphQl\Config\Data\TypeResolverInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

/**
 * {@inheritdoc}
 */
class AttributeInterfaceTypeResolver implements \Magento\Framework\GraphQl\Query\Resolver\TypeResolverInterface
{
    /**
     * {@inheritdoc}
     * @throws GraphQlInputException
     */
    public function resolveType(array $data) : string
    {
        return 'Attribute';
    }
}

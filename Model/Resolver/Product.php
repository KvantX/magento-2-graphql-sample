<?php
declare(strict_types=1);

namespace Hackathon\CatalogGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Query\ResolverInterface;

use \Magento\Catalog\Model\ProductFactory;

/**
 * Products field resolver, used for GraphQL request processing.
 */
class Product implements ResolverInterface
{
       /**
     * @var ValueFactory
     */
    private $valueFactory;

    protected $productloader;

    /**
     * @param ValueFactory $valueFactory
     */
    public function __construct(
        ValueFactory $valueFactory,
        ProductFactory $productloader
    ) {
        $this->productloader = $productloader;
        $this->valueFactory = $valueFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) : Value {


        $product = $this->productloader->create()->load($args['id']);

        $data = $product->getData();
        $data['model'] = $product;

        $result = function () use ($data) {
            return $data;
        };

        return $this->valueFactory->create($result);
    }
}

<?php
declare(strict_types=1);

namespace Hackathon\CatalogGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\Phrase;

/**
 * Category field resolver, used for GraphQL request processing.
 */
class Attribute implements ResolverInterface
{
    /**
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     *
     * @param ValueFactory $valueFactory
     */
    public function __construct(
        ValueFactory $valueFactory
    ) {
        $this->valueFactory = $valueFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null) : Value
    {
        $data = [];
        $product = $value['model'];
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getIsVisibleOnFront()) {
                $value = $attribute->getFrontend()->getValue($product);
                if ($value instanceof Phrase) {
                    $value = (string)$value;
                }
                if (is_string($value) && strlen($value)) {
                    $data []= [
                        'label' => $attribute->getFrontendLabel(),
                        'value' => $value,
                    ];
                }
            }
        }
        $result = function () use ($data) {
            return $data;
        };

        return $this->valueFactory->create($result);
    }
}

# BCMarketplace MultiShipVirtualFlow

## What It Does

This module allows customers to use multi-address checkout even when their cart contains only virtual or downloadable products. Normally, Magento prevents multi-address checkout for virtual products - this module removes that restriction.

## Installation

1. Install via Composer:
   ```bash
   composer require bcmarketplace/module-multiship-virtual-flow
   ```

2. Enable the module:
   ```bash
   bin/magento module:enable BCMarketplace_MultiShipVirtualFlow
   ```

3. Run setup upgrade:
   ```bash
   bin/magento setup:upgrade
   ```

4. Clear cache:
   ```bash
   bin/magento cache:flush
   ```

## How It Works

Once installed, customers with virtual or downloadable products can:

1. Add products to cart
2. Go to checkout
3. Select "Ship to Multiple Addresses"
4. Complete checkout (shipping steps are automatically skipped for virtual items)
5. Place order

The module automatically handles skipping unnecessary shipping steps for virtual products.

## Configuration

No configuration needed - the module works automatically once enabled.

## Testing

To test the module:

1. Add virtual/downloadable products to cart
2. Go to checkout
3. Select "Ship to Multiple Addresses"
4. Verify you can complete checkout without being redirected to cart

## Troubleshooting

**Still redirecting to cart?**
- Verify module is enabled: `bin/magento module:status`
- Clear cache: `bin/magento cache:flush`
- Recompile: `bin/magento setup:di:compile`

**Shipping steps not skipping?**
- Check that products are actually virtual
- Review logs: `var/log/exception.log`

## Support

**Author**: Raphael Baako  
**Email**: rbaako@baakoconsultingllc.com  
**Company**: Baako Consulting LLC

## License

Proprietary - All rights reserved.

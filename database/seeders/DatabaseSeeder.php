<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;
use App\Models\User;
use App\Models\Address;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Inventory;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use App\Models\ShippingMethod;
use App\Models\Tag;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderHistory;
use App\Models\NewsletterSubscriber;
use App\Models\ContactMessage;
use App\Models\RefundRequest;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        $admin = AdminUser::create([
            'name' => 'Fortunes Director',
            'email' => 'admin@fortunes.ng',
            'password' => Hash::make('Password123!'),
            'role' => 'superadmin',
        ]);

        // 2. Customer User & Admin User
        $customer = User::create([
            'name' => 'Korede Adeleke',
            'email' => 'korede@example.com',
            'phone' => '+2348023456789',
            'password' => Hash::make('Password123!'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $adminUserRecord = User::create([
            'name' => 'Fortunes Director',
            'email' => 'admin@fortunes.ng',
            'phone' => '+2348000000000',
            'password' => Hash::make('Password123!'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $address = Address::create([
            'user_id' => $customer->id,
            'recipient_name' => 'Korede Adeleke',
            'email' => 'korede@example.com',
            'phone' => '+2348023456789',
            'street_address' => 'Plot 12, PTI Road',
            'apartment' => 'Executive Suite',
            'city' => 'Effurun',
            'state' => 'Delta',
            'lga' => 'Uvwie',
            'country' => 'Nigeria',
            'postal_code' => '330102',
            'delivery_instructions' => 'Gate security call upon arrival.',
            'is_default' => true,
        ]);

        // 3. Categories
        $catTops = Category::create([
            'name' => 'TOPS',
            'slug' => 'tops',
            'description' => 'Heavyweight washed tees, tanks, tailored shirting, and luxury tactical vests.',
            'display_order' => 1,
            'is_active' => true,
        ]);

        $catBottoms = Category::create([
            'name' => 'BOTTOMS',
            'slug' => 'bottoms',
            'description' => 'Heavy baggy cargo denims, architectural trousers, and lounge track pants.',
            'display_order' => 2,
            'is_active' => true,
        ]);

        $catOuterwear = Category::create([
            'name' => 'OUTERWEAR',
            'slug' => 'outerwear',
            'description' => 'Racing track jackets, bonded bombers, and structured haute kimonos.',
            'display_order' => 3,
            'is_active' => true,
        ]);

        $catAccessories = Category::create([
            'name' => 'ACCESSORIES',
            'slug' => 'accessories',
            'description' => 'Solid brass and leather monogram belts, silk scarves, and headwear.',
            'display_order' => 4,
            'is_active' => true,
        ]);

        // 4. Hot Series Brand Collections (Fastest-Selling Luxury Brands)
        $colGenesis = Collection::create([
            'name' => 'GUCCI ATELIER EDIT',
            'slug' => 'gucci-series',
            'season' => 'FASTEST SELLING',
            'tagline' => 'High-velocity Italian luxury, signature monograms & heritage tailoring',
            'description' => 'Curated fastest-selling luxury house archive with bespoke hardware and iconic silhouettes.',
            'banner_image' => 'https://images.unsplash.com/photo-1548883354-7622d03aca27?q=80&w=1200&auto=format&fit=crop',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $colLekki = Collection::create([
            'name' => 'BALENCIAGA ARCHIVE',
            'slug' => 'balenciaga-series',
            'season' => 'HIGH HEAT',
            'tagline' => 'Deconstructed oversized proportions & avant-garde architectural cuts',
            'description' => 'Maximum demand street-luxury drops designed for bold, unapologetic presence.',
            'banner_image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1200&auto=format&fit=crop',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $colSahara = Collection::create([
            'name' => 'CASABLANCA CAPSULE',
            'slug' => 'casablanca-series',
            'season' => 'TRENDING NOW',
            'tagline' => 'Resort silk tailoring, vibrant Parisian tennis chic & sunset hues',
            'description' => 'Fastest-moving summer luxury vacationwear and handcrafted printed silks.',
            'banner_image' => 'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=1200&auto=format&fit=crop',
            'is_featured' => true,
            'is_active' => true,
        ]);

        // 5. Products Catalog
        $productsData = [
            [
                'name' => 'FORTUNES HEAVY BAGGY CARPENTER DENIM',
                'slug' => 'fortunes-heavy-baggy-carpenter-denim',
                'sku' => 'FC-DEN-001',
                'subtitle' => 'BOTTOMS / ARCHIVE',
                'short_description' => '16oz heavyweight Japanese selvedge denim with vintage mineral stone wash, double knee panels, and imperial gold hardware.',
                'description' => "Constructed from 16oz heavyweight rigid cotton denim sourced from Okayama and artisan-finished in Effurun. Features articulated double-knee construction, custom antique gold rivets, hammer loop, and an exaggerated wide-leg flare tailored for modern luxury proportions.\n\nPre-shrunk with an artisanal stone wash resulting in unique marble whiskering on every piece.",
                'details' => "• 100% 16oz Heavyweight Cotton Denim\n• Custom Fortunes stamped gold brass buttons\n• Relaxed oversized carpenter fit with floor sweep\n• 7-pocket architectural utility styling\n• Hand-finished in Effurun, Nigeria",
                'care_instructions' => "Dry clean recommended or machine wash cold inside out. Hang dry in shade to preserve indigo wash.",
                'size_guide' => "Model is 6'2\" (188cm) wearing size 32 (M). Fits intentionally oversized.",
                'price' => 299500.00,
                'compare_at_price' => 340000.00,
                'category_id' => $catBottoms->id,
                'collection_id' => $colGenesis->id,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'featured_image' => '/img/15.webp',
                'variants' => [
                    ['size' => 'S (30)', 'color' => 'Mineral Wash Grey', 'color_hex' => '#3D3D3D', 'stock' => 8],
                    ['size' => 'M (32)', 'color' => 'Mineral Wash Grey', 'color_hex' => '#3D3D3D', 'stock' => 12],
                    ['size' => 'L (34)', 'color' => 'Mineral Wash Grey', 'color_hex' => '#3D3D3D', 'stock' => 6],
                    ['size' => 'XL (36)', 'color' => 'Mineral Wash Grey', 'color_hex' => '#3D3D3D', 'stock' => 4],
                ],
            ],
            [
                'name' => 'FORTUNES EFFURUN ARCHIVE VINTAGE WASHED SHIRT',
                'slug' => 'fortunes-effurun-archive-vintage-washed-shirt',
                'sku' => 'FC-TEE-002',
                'subtitle' => 'TOPS / CLOTHING',
                'short_description' => '300 GSM custom-knit combed cotton tee with distressed edge trims, sun-faded pigment dye, and gold leaf typography.',
                'description' => "Our signature boxy silhouette t-shirt cut from high-density 300 GSM combed cotton. Treated with a sun-cured vintage dye process giving each garment a lived-in patina. Features tonal micro-distressing around collar and cuffs with subtle gold foil typographic branding across the lower hem.",
                'details' => "• 300 GSM Luxury Combed Cotton\n• Drop shoulder boxy streetwear cut\n• Pigment dye with subtle distressed ribbing\n• Imperial gold embroidered nape insignia\n• Made in Maison Fortunes Effurun",
                'care_instructions' => "Hand wash cold or gentle machine cycle. Do not bleach. Iron on reverse.",
                'size_guide' => "Model is 6'1\" wearing size L. Boxy relaxed fit.",
                'price' => 205000.00,
                'compare_at_price' => 225000.00,
                'category_id' => $catTops->id,
                'collection_id' => $colLekki->id,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'featured_image' => '/img/6.webp',
                'variants' => [
                    ['size' => 'S', 'color' => 'Earthy Terra Brown', 'color_hex' => '#4A3326', 'stock' => 10],
                    ['size' => 'M', 'color' => 'Earthy Terra Brown', 'color_hex' => '#4A3326', 'stock' => 15],
                    ['size' => 'L', 'color' => 'Earthy Terra Brown', 'color_hex' => '#4A3326', 'stock' => 8],
                    ['size' => 'XL', 'color' => 'Earthy Terra Brown', 'color_hex' => '#4A3326', 'stock' => 5],
                ],
            ],
            [
                'name' => 'FORTUNES PURE LEATHER MONOGRAM BELT',
                'slug' => 'fortunes-pure-leather-monogram-belt',
                'sku' => 'FC-ACC-003',
                'subtitle' => 'ACCESSORIES / LEATHER GOODS',
                'short_description' => 'Full-grain Italian calfskin leather belt with handcrafted solid brass Fortunes insignia in burnished antique gold.',
                'description' => "Crafted from 4mm thick vegetable-tanned full-grain leather that burnishes beautifully with age. Finished with hand-beveled wax-sealed edges and a heavy cast brass monogram buckle plated in 18k antique gold.",
                'details' => "• 100% Full-grain Tuscan calfskin leather\n• 18k Antique gold plated solid brass buckle\n• 38mm width fits standard denim and trousers\n• Hand-embossed serial numbering on reverse\n• Includes luxury presentation box and velvet dustbag",
                'care_instructions' => "Condition with natural beeswax leather cream annually.",
                'size_guide' => "Standard adjustable sizing from 30\" to 38\" waist.",
                'price' => 188000.00,
                'compare_at_price' => null,
                'category_id' => $catAccessories->id,
                'collection_id' => $colGenesis->id,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'status' => 'active',
                'featured_image' => '/img/25.webp',
                'variants' => [
                    ['size' => '85cm (30-32)', 'color' => 'Espresso Brown', 'color_hex' => '#2B1B17', 'stock' => 0], // Sold out demonstration
                    ['size' => '95cm (34-36)', 'color' => 'Espresso Brown', 'color_hex' => '#2B1B17', 'stock' => 0],
                ],
            ],
            [
                'name' => 'FORTUNES ARCHIVE CENTER GOLD LOGO TANK / GREY',
                'slug' => 'fortunes-archive-center-gold-logo-tank-grey',
                'sku' => 'FC-TNK-004',
                'subtitle' => 'TOPS / BASICS',
                'short_description' => 'Ribbed 280 GSM luxury combed cotton athletic tank with metallic gold 3D chest badge and dropped armholes.',
                'description' => "Elevated everyday luxury. Engineered from a proprietary 2x2 ribbed heavy stretch-cotton blend that holds its architectural shape wash after wash. Embellished with the Fortunes signature oval gold crest on the center chest.",
                'details' => "• 95% Combed Organic Cotton, 5% Elastane\n• Micro-ribbed bound neckline and armholes\n• 3D metallic liquid-gold silicone chest emblem\n• Lengthened scalloped hem for layering\n• Milled and tailored in Nigeria",
                'care_instructions' => "Machine wash cold with like colors. Do not tumble dry.",
                'size_guide' => "True to size for a fitted look; size up for oversized draping.",
                'price' => 139685.00,
                'compare_at_price' => 155000.00,
                'category_id' => $catTops->id,
                'collection_id' => $colLekki->id,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'status' => 'active',
                'featured_image' => '/img/product_663_1785067552_bgwhite.png',
                'variants' => [
                    ['size' => 'S', 'color' => 'Heather Platinum Grey', 'color_hex' => '#B0B0B0', 'stock' => 14],
                    ['size' => 'M', 'color' => 'Heather Platinum Grey', 'color_hex' => '#B0B0B0', 'stock' => 20],
                    ['size' => 'L', 'color' => 'Heather Platinum Grey', 'color_hex' => '#B0B0B0', 'stock' => 12],
                ],
            ],
            [
                'name' => 'FORTUNES CYBER SAHARA RACING SUIT / OBSIDIAN GOLD',
                'slug' => 'fortunes-cyber-sahara-racing-suit-obsidian-gold',
                'sku' => 'FC-OUT-005',
                'subtitle' => 'OUTERWEAR / LIMITED',
                'short_description' => 'Double-knit technical racing zip jacket and track trouser ensemble with golden piped seams and embroidered Maison heraldry.',
                'description' => "A masterclass in luxury sportswear. Cut from technical scuba cotton with high-sheen satin side tape and heavy two-way gold metal RiRi zippers. Designed for high speed, evening allure, and international grand touring.",
                'details' => "• 420 GSM Double-knit bonded interlock cotton\n• Two-way custom gold-dipped zippers with pull cords\n• Ergonomic raglan sleeve construction with gold piping\n• Hidden zipped storm pockets\n• Limited run of 100 numbered pieces worldwide",
                'care_instructions' => "Specialist dry clean only.",
                'size_guide' => "Athletic tailored cut. Size up for relaxed streetwear drape.",
                'price' => 380000.00,
                'compare_at_price' => 420000.00,
                'category_id' => $catOuterwear->id,
                'collection_id' => $colSahara->id,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'featured_image' => '/img/product_416_1774022423_resized_opt_opt.webp',
                'variants' => [
                    ['size' => 'M', 'color' => 'Obsidian Black / Gold', 'color_hex' => '#0A0A0A', 'stock' => 5],
                    ['size' => 'L', 'color' => 'Obsidian Black / Gold', 'color_hex' => '#0A0A0A', 'stock' => 7],
                    ['size' => 'XL', 'color' => 'Obsidian Black / Gold', 'color_hex' => '#0A0A0A', 'stock' => 3],
                ],
            ],
            [
                'name' => 'FORTUNES NIGERIA IS REAL HAUTE OVERSIZED HOODIE',
                'slug' => 'fortunes-nigeria-is-real-haute-oversized-hoodie',
                'sku' => 'FC-HOD-006',
                'subtitle' => 'TOPS / STATEMENTS',
                'short_description' => '480 GSM French Terry hoodie with drop shoulders, double-layer crossover hood, and high-density gold screen typography.',
                'description' => "Our bold statement piece celebrating contemporary African creative resurgence. Dense 480 GSM diagonal loopback French Terry that holds an imposing, sculptural silhouette. No drawstrings for a clean, minimalist neckline.",
                'details' => "• 480 GSM Organic Cotton French Terry\n• Heavy 2x2 ribbed cuffs and hem\n• High-density gold puff print statement on back\n• Clean seamless front kangaroo pocket\n• Preshrunk for lifetime structural retention",
                'care_instructions' => "Machine wash cold inside-out. Air dry only.",
                'size_guide' => "Intentionally oversized. Order true to size for signature drape.",
                'price' => 265000.00,
                'compare_at_price' => 295000.00,
                'category_id' => $catTops->id,
                'collection_id' => $colGenesis->id,
                'is_featured' => false,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'featured_image' => '/img/4.webp',
                'variants' => [
                    ['size' => 'S', 'color' => 'Deep Royal Navy', 'color_hex' => '#111C24', 'stock' => 9],
                    ['size' => 'M', 'color' => 'Deep Royal Navy', 'color_hex' => '#111C24', 'stock' => 16],
                    ['size' => 'L', 'color' => 'Deep Royal Navy', 'color_hex' => '#111C24', 'stock' => 11],
                    ['size' => 'XL', 'color' => 'Deep Royal Navy', 'color_hex' => '#111C24', 'stock' => 6],
                ],
            ],
            [
                'name' => 'FORTUNES TACTICAL CARGO COMBAT TROUSERS',
                'slug' => 'fortunes-tactical-cargo-combat-trousers',
                'sku' => 'FC-CRG-007',
                'subtitle' => 'BOTTOMS / UTILITY',
                'short_description' => 'Heavyweight ripstop trousers with modular zip-off pockets, adjustable ankle bungee toggles, and gold D-ring clips.',
                'description' => "Military-inspired tactical design recalibrated for high luxury. Engineered from durable cotton ripstop with water-resistant coating. Features 8 anatomical utility compartments and custom gold anodized aluminum clip fasteners.",
                'details' => "• 100% High-tensile Cotton Ripstop\n• Anodized gold aircraft-grade hardware\n• Bungee cinching at hem for tapered or flared styling\n• Articulated knees for effortless mobility\n• Made in Effurun",
                'care_instructions' => "Machine wash cold. Do not tumble dry.",
                'size_guide' => "Elasticated waistband with internal drawcord. Size M fits waist 31-33.",
                'price' => 245000.00,
                'compare_at_price' => null,
                'category_id' => $catBottoms->id,
                'collection_id' => $colSahara->id,
                'is_featured' => false,
                'is_new' => false,
                'is_bestseller' => false,
                'status' => 'active',
                'featured_image' => '/img/20.webp',
                'variants' => [
                    ['size' => 'S', 'color' => 'Tactical Cyber Olive', 'color_hex' => '#4D543B', 'stock' => 4],
                    ['size' => 'M', 'color' => 'Tactical Cyber Olive', 'color_hex' => '#4D543B', 'stock' => 8],
                    ['size' => 'L', 'color' => 'Tactical Cyber Olive', 'color_hex' => '#4D543B', 'stock' => 7],
                ],
            ],
            [
                'name' => 'FORTUNES GOLD EMBROIDERED MAISON KIMONO',
                'slug' => 'fortunes-gold-embroidered-maison-kimono',
                'sku' => 'FC-KIM-008',
                'subtitle' => 'OUTERWEAR / HAUTE',
                'short_description' => 'Structured raw linen and silk kimono coat featuring artisanal gold bullion embroidery depicting Nigerian architectural heritage.',
                'description' => "The pinnacle of the Fortunes Atelier. A fusion of traditional African drapery and Japanese ceremonial tailoring. Each piece requires 28 hours of precision gold thread needlework by master artisans in our Effurun atelier.",
                'details' => "• 60% Raw Slub Linen, 40% Mulberry Silk\n• Intricate gold metallic bullion embroidery\n• Open front with self-fabric wrap sash\n• Dual internal jet pockets\n• Hand-finished limited production",
                'care_instructions' => "Specialist museum-grade dry clean only.",
                'size_guide' => "Free size (O/S) designed to drape elegantly on sizes S through XXL.",
                'price' => 340000.00,
                'compare_at_price' => 390000.00,
                'category_id' => $catOuterwear->id,
                'collection_id' => $colGenesis->id,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'status' => 'active',
                'featured_image' => '/img/12.webp',
                'variants' => [
                    ['size' => 'One Size', 'color' => 'Raw Dover Ivory / Gold', 'color_hex' => '#F4EFE6', 'stock' => 5],
                    ['size' => 'One Size', 'color' => 'Obsidian Black / Gold', 'color_hex' => '#0A0A0A', 'stock' => 3],
                ],
            ],
        ];

        foreach ($productsData as $data) {
            $variants = $data['variants'];
            unset($data['variants']);

            $product = Product::create($data);

            // Primary Image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $product->featured_image,
                'is_primary' => true,
                'alt_text' => $product->name,
                'sort_order' => 1,
            ]);

            // Add secondary image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $product->featured_image,
                'is_primary' => false,
                'alt_text' => $product->name . ' - Detail',
                'sort_order' => 2,
            ]);

            foreach ($variants as $idx => $v) {
                $sizeCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $v['size']), 0, 3));
                $colorCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $v['color']), 0, 3));
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $v['size'],
                    'color' => $v['color'],
                    'color_hex' => $v['color_hex'],
                    'sku' => $product->sku . '-' . $sizeCode . '-' . $colorCode,
                    'stock_quantity' => $v['stock'],
                    'is_available' => $v['stock'] > 0,
                ]);

                Inventory::create([
                    'product_id' => $product->id,
                    'product_variant_id' => $variant->id,
                    'stock_count' => $v['stock'],
                    'low_stock_threshold' => 5,
                    'reserved_count' => 0,
                ]);
            }

            // Reviews
            Review::create([
                'product_id' => $product->id,
                'user_id' => $customer->id,
                'author_name' => 'Korede Adeleke',
                'author_email' => 'korede@example.com',
                'rating' => 5,
                'title' => 'Unbelievable quality and presence',
                'comment' => 'The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',
                'is_verified_purchase' => true,
                'is_approved' => true,
            ]);

            Review::create([
                'product_id' => $product->id,
                'author_name' => 'Chioma N.',
                'rating' => 5,
                'title' => 'Couture perfection',
                'comment' => 'Arrived in Effurun within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',
                'is_verified_purchase' => true,
                'is_approved' => true,
            ]);
        }

        // 6. Testimonials
        Testimonial::create([
            'author_name' => 'Burna B.',
            'author_title' => 'Artist & Global Cultural Icon',
            'quote' => 'Fortunes Collection is redefining what African luxury looks like on the world stage. Uncompromising swagger and craft.',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop',
            'rating' => 5,
            'display_order' => 1,
            'is_active' => true,
        ]);

        Testimonial::create([
            'author_name' => 'Genevieve E.',
            'author_title' => 'Haute Couture Collector, London / Effurun',
            'quote' => 'The tailoring in their Effurun Maison is second to none. The gold accents feel royal without being loud. Pure elegance.',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop',
            'rating' => 5,
            'display_order' => 2,
            'is_active' => true,
        ]);

        // 7. Coupons
        Coupon::create([
            'code' => 'FORTUNES10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_spend' => 100000.00,
            'max_discount' => 50000.00,
            'usage_limit' => 500,
            'used_count' => 14,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'EFFURUN2026',
            'type' => 'fixed',
            'value' => 30000.00,
            'min_spend' => 200000.00,
            'usage_limit' => 100,
            'used_count' => 8,
            'is_active' => true,
        ]);

        // 8. Orders for Analytics & Dashboard
        $firstProduct = Product::first();
        $firstVariant = $firstProduct->variants()->first();

        // Sample Paid Order
        $order1 = Order::create([
            'order_number' => 'FC-2026-89421',
            'user_id' => $customer->id,
            'customer_name' => 'Korede Adeleke',
            'customer_email' => 'korede@example.com',
            'customer_phone' => '+2348023456789',
            'shipping_address_id' => $address->id,
            'shipping_method' => 'effurun_vip',
            'status' => 'paid',
            'currency' => 'NGN',
            'subtotal' => 504500.00,
            'discount_amount' => 50000.00,
            'shipping_fee' => 3500.00,
            'tax_amount' => 0.00,
            'total_amount' => 458000.00,
            'coupon_code' => 'FORTUNES10',
            'payment_method' => 'paystack',
            'payment_status' => 'paid',
            'tracking_number' => 'FC-TRK-774910',
            'courier_name' => 'Maison Effurun Dedicated Courier',
            'internal_notes' => 'Customer requested gold wax seal on exterior envelope.',
            'paid_at' => now()->subHours(5),
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $firstProduct->id,
            'product_variant_id' => $firstVariant->id,
            'product_name' => $firstProduct->name,
            'product_sku' => $firstVariant->sku,
            'variant_details' => 'Size: ' . $firstVariant->size . ' / Color: ' . $firstVariant->color,
            'unit_price' => $firstProduct->price,
            'quantity' => 1,
            'subtotal' => $firstProduct->price,
            'product_image' => $firstProduct->featured_image,
        ]);

        Payment::create([
            'order_id' => $order1->id,
            'provider' => 'paystack',
            'reference' => 'PSTK_LIVE_REF_' . bin2hex(random_bytes(6)),
            'transaction_id' => 'TRX_88492014',
            'amount' => 458000.00,
            'currency' => 'NGN',
            'channel' => 'card',
            'status' => 'successful',
            'gateway_response' => 'Approved',
            'verified_at' => now()->subHours(5),
        ]);

        // Sample Processing Order
        $secondProduct = Product::skip(1)->first();
        $order2 = Order::create([
            'order_number' => 'FC-2026-90142',
            'customer_name' => 'Folake Balogun',
            'customer_email' => 'folake.b@outlook.com',
            'customer_phone' => '+2348149876543',
            'shipping_method' => 'delta_express',
            'status' => 'processing',
            'currency' => 'NGN',
            'subtotal' => 205000.00,
            'discount_amount' => 0.00,
            'shipping_fee' => 4500.00,
            'tax_amount' => 0.00,
            'total_amount' => 209500.00,
            'payment_method' => 'paystack',
            'payment_status' => 'paid',
            'internal_notes' => 'Preparing for dispatch to Warri / Effurun enclave.',
            'paid_at' => now()->subHours(2),
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $secondProduct->id,
            'product_name' => $secondProduct->name,
            'product_sku' => $secondProduct->sku,
            'variant_details' => 'Size: M / Color: Earthy Terra Brown',
            'unit_price' => $secondProduct->price,
            'quantity' => 1,
            'subtotal' => $secondProduct->price,
            'product_image' => $secondProduct->featured_image,
        ]);

        // 9. Site Settings
        SiteSetting::set('announcement_ticker', 'MADE IN NIGERIA FOR THE WORLD ⬝ MAISON FORTUNES EFFURUN OPEN ⬝ COMPLIMENTARY EFFURUN SAME-DAY DISPATCH ⬝ ARCHIVE 2026', 'header');
        SiteSetting::set('hero_title', 'FORTUNES COLLECTION', 'hero');
        SiteSetting::set('hero_subtitle', 'WHERE PASSION MEETS FASHION', 'hero');
        SiteSetting::set('maison_address', 'PLOT 12, PTI ROAD, EFFURUN, DELTA STATE', 'maison');
        SiteSetting::set('maison_status', 'CURRENT STATUS: ARCHIVE 03 PRODUCTION', 'maison');
        SiteSetting::set('customer_service_phone', '+234 1 888 3490', 'general');
        SiteSetting::set('customer_service_email', 'concierge@fortunes.ng', 'general');

        // 10. Shipping Methods (Effurun, Delta, Nationwide, Global)
        ShippingMethod::create([
            'name' => 'Effurun White-Glove VIP Courier',
            'code' => 'effurun_vip',
            'description' => 'Direct hand-delivery within PTI Road, Effurun & Warri metropolis.',
            'base_cost' => 0.00,
            'cost_per_kg' => 0.00,
            'free_shipping_min_amount' => 0.00,
            'estimated_delivery_days' => 'Same Day (2 - 4 hours)',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        ShippingMethod::create([
            'name' => 'Delta State Priority Dispatch',
            'code' => 'delta_express',
            'description' => 'Dedicated insured logistics across Asaba, Sapele, Ughelli & Delta State.',
            'base_cost' => 4500.00,
            'cost_per_kg' => 500.00,
            'free_shipping_min_amount' => 150000.00,
            'estimated_delivery_days' => '24 Hours',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        ShippingMethod::create([
            'name' => 'Lagos & Abuja Executive Express',
            'code' => 'lagos_abuja_express',
            'description' => 'Overnight priority courier to Lagos Island, Victoria Island, Ikoyi & Abuja FCT.',
            'base_cost' => 7500.00,
            'cost_per_kg' => 1000.00,
            'free_shipping_min_amount' => 300000.00,
            'estimated_delivery_days' => '1 - 2 Business Days',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        ShippingMethod::create([
            'name' => 'DHL Worldwide Express (International)',
            'code' => 'dhl_intl',
            'description' => 'Global door-to-door courier tracking across United Kingdom, US, Canada & Europe.',
            'base_cost' => 42000.00,
            'cost_per_kg' => 5000.00,
            'free_shipping_min_amount' => 1000000.00,
            'estimated_delivery_days' => '3 - 5 Business Days',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // 11. Tags & Product Taxonomy
        $tagBespoke = Tag::create(['name' => 'Bespoke Tailoring', 'slug' => 'bespoke-tailoring', 'type' => 'style']);
        $tagArchive = Tag::create(['name' => 'Archive 2026', 'slug' => 'archive-2026', 'type' => 'collection']);
        $tagSilk = Tag::create(['name' => 'Raw Silk', 'slug' => 'raw-silk', 'type' => 'material']);
        $tagLimited = Tag::create(['name' => 'Limited Edition', 'slug' => 'limited-edition', 'type' => 'badge']);
        $tagDelta = Tag::create(['name' => 'Delta Heritage', 'slug' => 'delta-heritage', 'type' => 'featured']);

        $firstProd = Product::first();
        if ($firstProd) {
            $firstProd->tags()->syncWithoutDetaching([$tagBespoke->id, $tagArchive->id, $tagSilk->id, $tagLimited->id]);
        }
        if ($secondProduct) {
            $secondProduct->tags()->syncWithoutDetaching([$tagArchive->id, $tagDelta->id]);
        }

        // 12. Order Histories
        OrderHistory::create([
            'order_id' => $order1->id,
            'status' => 'pending',
            'notes' => 'Order initiated at checkout.',
            'notified_customer' => true,
            'action_by' => 'customer',
        ]);
        OrderHistory::create([
            'order_id' => $order1->id,
            'status' => 'paid',
            'notes' => 'Paystack webhook verified payment of ₦378,000.',
            'notified_customer' => true,
            'action_by' => 'gateway',
        ]);

        OrderHistory::create([
            'order_id' => $order2->id,
            'status' => 'processing',
            'notes' => 'Garment inspection complete at PTI Road Atelier. Packed in signature Fortunes gold dust bag.',
            'notified_customer' => true,
            'action_by' => 'admin',
        ]);

        // 13. Newsletter & Concierge Club
        NewsletterSubscriber::create([
            'email' => 'vip.client@fortunes.ng',
            'name' => 'VIP Client Services',
            'status' => 'subscribed',
            'source' => 'footer',
            'subscribed_at' => now(),
        ]);
        NewsletterSubscriber::create([
            'email' => 'atelier.member@fortunes.ng',
            'name' => 'Effurun Atelier Patron',
            'status' => 'subscribed',
            'source' => 'checkout',
            'subscribed_at' => now(),
        ]);

        // 14. Concierge Contact Inquiries
        ContactMessage::create([
            'user_id' => $customer->id,
            'name' => 'Korede Adeleke',
            'email' => 'korede@example.com',
            'phone' => '+2348023456789',
            'subject' => 'Private Atelier Consultation for Traditional Wedding',
            'message' => 'Good day Fortunes team. I would like to schedule a private fitting session at the PTI Road Maison for a bespoke 3-piece Kaftan ensemble.',
            'status' => 'unread',
            'admin_notes' => 'Follow up via WhatsApp to schedule atelier appointment.',
        ]);
    }
}

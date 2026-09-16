<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Inventory;
use App\Models\Review;

$catTops = Category::where('slug', 'tops')->first();
$catBottoms = Category::where('slug', 'bottoms')->first();
$catOuterwear = Category::where('slug', 'outerwear')->first();
$catAccessories = Category::where('slug', 'accessories')->first();

$colGenesis = Collection::where('slug', 'genesis-archive')->first() ?? Collection::first();
$colLekki = Collection::where('slug', 'effurun-nocturne')->first() ?? Collection::first();
$colSahara = Collection::where('slug', 'cyber-sahara')->first() ?? Collection::first();

// 1. Update Existing 8 Products to Exact Real Images
$existingUpdates = [
    1 => [
        'featured_image' => '/img/15.webp',
        'subtitle' => 'BOTTOMS / HEAVY CARPENTER',
        'additional_images' => ['/img/22.webp', '/img/1.webp'],
    ],
    2 => [
        'featured_image' => '/img/6.webp',
        'subtitle' => 'TOPS / VINTAGE STRIPED',
        'additional_images' => ['/img/18.webp'],
    ],
    3 => [
        'featured_image' => '/img/25.webp',
        'subtitle' => 'ACCESSORIES / LEATHER GOODS',
        'additional_images' => [],
    ],
    4 => [
        'featured_image' => '/img/product_663_1785067552_bgwhite.png',
        'subtitle' => 'TOPS / ATHLETIC RIBBED',
        'additional_images' => ['/img/7.webp'],
    ],
    5 => [
        'featured_image' => '/img/product_416_1774022423_resized_opt_opt.webp',
        'subtitle' => 'OUTERWEAR / RACING SUIT',
        'additional_images' => ['/img/3.webp', '/img/14.webp'],
    ],
    6 => [
        'featured_image' => '/img/4.webp',
        'subtitle' => 'TOPS / FRENCH TERRY',
        'additional_images' => ['/img/5.webp', '/img/10.webp'],
    ],
    7 => [
        'featured_image' => '/img/20.webp',
        'subtitle' => 'BOTTOMS / TACTICAL UTILITY',
        'additional_images' => ['/img/11.webp'],
    ],
    8 => [
        'featured_image' => '/img/12.webp',
        'subtitle' => 'OUTERWEAR / MONOGRAM HAUTE',
        'additional_images' => ['/img/19.webp'],
    ],
];

foreach ($existingUpdates as $id => $data) {
    $product = Product::find($id);
    if ($product) {
        $product->update([
            'featured_image' => $data['featured_image'],
            'subtitle' => $data['subtitle'],
        ]);

        // Clean & Re-create product images
        ProductImage::where('product_id', $product->id)->delete();
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $data['featured_image'],
            'is_primary' => true,
            'alt_text' => $product->name,
            'sort_order' => 1,
        ]);

        $sort = 2;
        foreach ($data['additional_images'] as $addImg) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $addImg,
                'is_primary' => false,
                'alt_text' => $product->name . ' - Angle',
                'sort_order' => $sort++,
            ]);
        }
        echo "Updated product {$id}: {$product->name} -> {$data['featured_image']}\n";
    }
}

// 2. Add New Authentic Products from the Remaining Images in img/
$newProducts = [
    // TOPS
    [
        'name' => 'FORTUNES TALES FROM A YOUNG BLACK BOY ART SHIRT',
        'slug' => 'fortunes-tales-from-a-young-black-boy-art-shirt',
        'sku' => 'FC-ART-009',
        'subtitle' => 'TOPS / GRAPHIC COUTURE',
        'short_description' => 'Fine poplin resort collar shirt celebrating Nigerian street life, Warri architecture, and contemporary African identity.',
        'description' => 'A canvas in motion. Rich pigment prints featuring Warri iconography, yellow Danfo buses, and Benin bronze masks on crisp breathable cotton poplin.',
        'details' => "• 100% Lightweight Luxury Cotton Poplin\n• Camp collar silhouette with French seam finishes\n• Vibrant multi-color high-definition pigment print\n• Custom Fortunes gold engraved buttons\n• Artisan-made in Effurun",
        'care_instructions' => 'Gentle hand wash cold or dry clean. Cool iron on reverse.',
        'size_guide' => 'Relaxed boxy fit. Fits true to size.',
        'price' => 185000.00,
        'compare_at_price' => 210000.00,
        'category_id' => $catTops->id,
        'collection_id' => $colLekki->id,
        'is_featured' => true,
        'is_new' => true,
        'is_bestseller' => true,
        'status' => 'active',
        'featured_image' => '/img/21.webp',
        'variants' => [
            ['size' => 'S', 'color' => 'Sky Blue Art', 'color_hex' => '#93C5FD', 'stock' => 10],
            ['size' => 'M', 'color' => 'Sky Blue Art', 'color_hex' => '#93C5FD', 'stock' => 14],
            ['size' => 'L', 'color' => 'Sky Blue Art', 'color_hex' => '#93C5FD', 'stock' => 8],
        ],
    ],
    [
        'name' => 'FORTUNES BLACK SHEEP COUTURE GRAPHIC TEE',
        'slug' => 'fortunes-black-sheep-couture-graphic-tee',
        'sku' => 'FC-TEE-010',
        'subtitle' => 'TOPS / STATEMENT',
        'short_description' => 'Heavyweight 320 GSM combed cotton tee featuring the iconic gold-framed Black Sheep emblem and manifesto print.',
        'description' => 'Constructed from heavy 320 GSM structured cotton jersey. Features our gilded ram crest and fearless game-changer manifesto on the reverse.',
        'details' => "• 320 GSM Heavyweight Combed Cotton\n• Thick 1.25\" rib crewneck collar\n• High-definition puff and screen print\n• Pre-shrunk for maximum shape retention",
        'care_instructions' => 'Machine wash cold inside out. Hang dry only.',
        'size_guide' => 'Boxy oversized fit.',
        'price' => 125000.00,
        'compare_at_price' => 140000.00,
        'category_id' => $catTops->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => true,
        'is_new' => true,
        'is_bestseller' => true,
        'status' => 'active',
        'featured_image' => '/img/17.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Obsidian Black', 'color_hex' => '#0A0A0A', 'stock' => 18],
            ['size' => 'L', 'color' => 'Obsidian Black', 'color_hex' => '#0A0A0A', 'stock' => 12],
            ['size' => 'XL', 'color' => 'Obsidian Black', 'color_hex' => '#0A0A0A', 'stock' => 6],
        ],
    ],
    [
        'name' => 'FORTUNES EFFURUN NOCTURNE OLIVE HOODIE',
        'slug' => 'fortunes-effurun-nocturne-olive-hoodie',
        'sku' => 'FC-HOD-011',
        'subtitle' => 'TOPS / QUARTER-ZIP',
        'short_description' => 'Tactical quarter-zip French Terry hoodie with funnel neck, signature purple zip pull, and contrast yellow embroidery.',
        'description' => 'Heavyweight 450 GSM French Terry cut in a structured streetwear silhouette. Finished with a heavy brass zipper, nylon pull cord, and reinforced kangaroo pouch.',
        'details' => "• 450 GSM Organic Cotton French Terry\n• Funnel neck quarter-zip collar\n• Signature detachable purple woven pull ribbon\n• Thick ribbed waistband and cuffs",
        'care_instructions' => 'Machine wash cold. Do not tumble dry.',
        'size_guide' => 'Generous streetwear cut.',
        'price' => 245000.00,
        'compare_at_price' => null,
        'category_id' => $catTops->id,
        'collection_id' => $colLekki->id,
        'is_featured' => false,
        'is_new' => true,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/10.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Sage Olive', 'color_hex' => '#708238', 'stock' => 12],
            ['size' => 'L', 'color' => 'Sage Olive', 'color_hex' => '#708238', 'stock' => 9],
        ],
    ],
    [
        'name' => 'FORTUNES STRIPED RUGBY KNIT POLO',
        'slug' => 'fortunes-striped-rugby-knit-polo',
        'sku' => 'FC-POL-012',
        'subtitle' => 'TOPS / KNITWEAR',
        'short_description' => 'Heavyweight navy and goldenrod striped rugby polo with contrast gold collar and chenille logo embroidery.',
        'description' => 'A heritage staple revitalized. Dense interlock cotton knit with vibrant horizontal block stripes and covered placket with woven zip ribbon.',
        'details' => "• 100% Interlock Cotton\n• Stiffened contrast golden collar\n• Chenille embroidered chest lettering\n• Side hem vents for easy layering",
        'care_instructions' => 'Hand wash cold or gentle machine cycle. Dry flat.',
        'size_guide' => 'Standard classic fit.',
        'price' => 175000.00,
        'compare_at_price' => 195000.00,
        'category_id' => $catTops->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => false,
        'is_new' => false,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/18.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Navy / Gold', 'color_hex' => '#1E3A8A', 'stock' => 10],
            ['size' => 'L', 'color' => 'Navy / Gold', 'color_hex' => '#1E3A8A', 'stock' => 15],
        ],
    ],
    [
        'name' => 'FORTUNES FOREST GREEN CREWNECK SWEATSHIRT',
        'slug' => 'fortunes-forest-green-crewneck-sweatshirt',
        'sku' => 'FC-CRW-013',
        'subtitle' => 'TOPS / FLEECE',
        'short_description' => 'Tonal embossed fleece crewneck in deep forest green with raglan sleeve ergonomics and cross-stitch collar.',
        'description' => 'Clean minimalist luxury. 400 GSM brushed fleece featuring tonal 3D chest embossing and reinforced vintage cross-v neck stitch.',
        'details' => "• 400 GSM Brushed Back Fleece\n• Tonal embossed Fortunes branding\n• Classic raglan sleeve architecture\n• Custom neck label with metallic serial clip",
        'care_instructions' => 'Machine wash cold. Cool tumble dry.',
        'size_guide' => 'True to size.',
        'price' => 165000.00,
        'compare_at_price' => null,
        'category_id' => $catTops->id,
        'collection_id' => $colLekki->id,
        'is_featured' => false,
        'is_new' => false,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/24.webp',
        'variants' => [
            ['size' => 'S', 'color' => 'Forest Green', 'color_hex' => '#1B4D3E', 'stock' => 8],
            ['size' => 'M', 'color' => 'Forest Green', 'color_hex' => '#1B4D3E', 'stock' => 12],
            ['size' => 'L', 'color' => 'Forest Green', 'color_hex' => '#1B4D3E', 'stock' => 10],
        ],
    ],
    [
        'name' => 'FORTUNES WHITE RIBBED ATELIER TANK',
        'slug' => 'fortunes-white-ribbed-atelier-tank',
        'sku' => 'FC-TNK-014',
        'subtitle' => 'TOPS / ESSENTIALS',
        'short_description' => 'Fine-gauge white ribbed cotton tank with centered oval Fortunes seal and dropped neckline.',
        'description' => 'Crisp organic stretch cotton with a smooth sculpted profile. Ideal as a standalone statement in warm weather or an atelier underlayer.',
        'details' => "• 95% Organic Cotton, 5% Spandex\n• Center 3D silicone brand seal\n• Micro-ribbed neckline binding",
        'care_instructions' => 'Machine wash cold. Lay flat to dry.',
        'size_guide' => 'Sculpted fit.',
        'price' => 95000.00,
        'compare_at_price' => 110000.00,
        'category_id' => $catTops->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => false,
        'is_new' => false,
        'is_bestseller' => true,
        'status' => 'active',
        'featured_image' => '/img/7.webp',
        'variants' => [
            ['size' => 'S', 'color' => 'Chalk White', 'color_hex' => '#FFFFFF', 'stock' => 20],
            ['size' => 'M', 'color' => 'Chalk White', 'color_hex' => '#FFFFFF', 'stock' => 25],
        ],
    ],

    // BOTTOMS
    [
        'name' => 'FORTUNES VINTAGE FLARED SELVEDGE DENIM',
        'slug' => 'fortunes-vintage-flared-selvedge-denim',
        'sku' => 'FC-DEN-015',
        'subtitle' => 'BOTTOMS / FLARED ARCHIVE',
        'short_description' => 'Light-wash 15oz selvedge denim with natural sun fading, flared hem opening, and embroidered knee typography.',
        'description' => 'Tailored for dramatic shoe pooling and timeless proportion. Features hand-sanded whiskering, customized antique brass rivets, and embroidered leg detailing.',
        'details' => "• 100% 15oz Indigo Cotton Selvedge\n• Subtle bell flare from knee to hem\n• Custom back leather logo patch\n• Stitched embroidery on lower leg",
        'care_instructions' => 'Wash sparingly inside out in cold water.',
        'size_guide' => 'Fitted through thigh, flares at hem.',
        'price' => 275000.00,
        'compare_at_price' => 310000.00,
        'category_id' => $catBottoms->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => true,
        'is_new' => true,
        'is_bestseller' => true,
        'status' => 'active',
        'featured_image' => '/img/1.webp',
        'variants' => [
            ['size' => '30', 'color' => 'Light Mineral Indigo', 'color_hex' => '#93C5FD', 'stock' => 6],
            ['size' => '32', 'color' => 'Light Mineral Indigo', 'color_hex' => '#93C5FD', 'stock' => 10],
            ['size' => '34', 'color' => 'Light Mineral Indigo', 'color_hex' => '#93C5FD', 'stock' => 7],
        ],
    ],
    [
        'name' => 'FORTUNES TERRACOTTA ARCHIVE WOVEN TROUSERS',
        'slug' => 'fortunes-terracotta-archive-woven-trousers',
        'sku' => 'FC-TRS-016',
        'subtitle' => 'BOTTOMS / ARCHITECTURAL',
        'short_description' => 'Wide-leg architectural trousers in textured terracotta slub weave with deep front pleats.',
        'description' => 'Woven on heritage looms from slub-spun cotton yarn. Features a high-waisted rise, double front pleats, and an expansive wide leg silhouette.',
        'details' => "• 100% Textured Slub Woven Cotton\n• High-waisted with extended tab closure\n• Deep double architectural pleats\n• Horn buttons with gold backstays",
        'care_instructions' => 'Dry clean or steam only.',
        'size_guide' => 'True to size high-waist fit.',
        'price' => 230000.00,
        'compare_at_price' => null,
        'category_id' => $catBottoms->id,
        'collection_id' => $colLekki->id,
        'is_featured' => false,
        'is_new' => true,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/11.webp',
        'variants' => [
            ['size' => '30', 'color' => 'Terracotta Brick', 'color_hex' => '#C85A32', 'stock' => 5],
            ['size' => '32', 'color' => 'Terracotta Brick', 'color_hex' => '#C85A32', 'stock' => 8],
            ['size' => '34', 'color' => 'Terracotta Brick', 'color_hex' => '#C85A32', 'stock' => 4],
        ],
    ],
    [
        'name' => 'FORTUNES CASSETTE PATCH WORK DENIM',
        'slug' => 'fortunes-cassette-patch-work-denim',
        'sku' => 'FC-DEN-017',
        'subtitle' => 'BOTTOMS / ARTISAN CUSTOM',
        'short_description' => 'Distressed washed blue denim featuring embroidered vinyl record, cassette mixtape, and mystic eye patches.',
        'description' => 'An ode to vintage Nigerian vinyl culture and sound systems. Each pair is uniquely distressed with raw knee rips and embroidered felt patches.',
        'details' => "• 14.5oz Vintage Ring-Spun Cotton Denim\n• Custom embroidered archival felt patches\n• Hand-distressed knee abrasions\n• Loose baggy carpenter drape",
        'care_instructions' => 'Machine wash cold gentle cycle. Air dry.',
        'size_guide' => 'Relaxed baggy fit.',
        'price' => 285000.00,
        'compare_at_price' => 320000.00,
        'category_id' => $catBottoms->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => false,
        'is_new' => true,
        'is_bestseller' => true,
        'status' => 'active',
        'featured_image' => '/img/22.webp',
        'variants' => [
            ['size' => '32', 'color' => 'Medium Vintage Blue', 'color_hex' => '#60A5FA', 'stock' => 7],
            ['size' => '34', 'color' => 'Medium Vintage Blue', 'color_hex' => '#60A5FA', 'stock' => 5],
        ],
    ],

    // OUTERWEAR
    [
        'name' => 'FORTUNES CYBER SAHARA RACING SUIT / CRIMSON',
        'slug' => 'fortunes-cyber-sahara-racing-suit-crimson',
        'sku' => 'FC-OUT-018',
        'subtitle' => 'OUTERWEAR / GRAND TOURING',
        'short_description' => 'Crimson red and obsidian technical racing jacket and track trousers with ergonomic curved panels and ankle bungees.',
        'description' => 'High-velocity sportswear tailoring. Cut from technical bonded scuba with articulated black contrast panels, zipper storm pockets, and bungee hem toggles.',
        'details' => "• 420 GSM Bonded Technical Scuba\n• Full two-piece suit set (Jacket + Trousers)\n• Anodized gold zipper hardware\n• Adjustable bungee hem cinch cords",
        'care_instructions' => 'Dry clean or hand wash cold.',
        'size_guide' => 'Athletic tailored fit.',
        'price' => 380000.00,
        'compare_at_price' => 420000.00,
        'category_id' => $catOuterwear->id,
        'collection_id' => $colSahara->id,
        'is_featured' => true,
        'is_new' => true,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/3.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Crimson / Obsidian', 'color_hex' => '#DC2626', 'stock' => 6],
            ['size' => 'L', 'color' => 'Crimson / Obsidian', 'color_hex' => '#DC2626', 'stock' => 8],
        ],
    ],
    [
        'name' => 'FORTUNES CYBER SAHARA RACING SUIT / AZURE',
        'slug' => 'fortunes-cyber-sahara-racing-suit-azure',
        'sku' => 'FC-OUT-019',
        'subtitle' => 'OUTERWEAR / GRAND TOURING',
        'short_description' => 'Sky blue and ice grey technical racing suit ensemble with reflective orange seam piping.',
        'description' => 'Futuristic track architecture rendered in brilliant azure and silver grey. Full two-piece set designed for stage presence and effortless motion.',
        'details' => "• Bonded technical stretch scuba\n• High-visibility piping along curved body lines\n• Full two-piece matching set\n• Custom purple zipper pull ribbons",
        'care_instructions' => 'Specialist clean recommended.',
        'size_guide' => 'Athletic fit.',
        'price' => 380000.00,
        'compare_at_price' => null,
        'category_id' => $catOuterwear->id,
        'collection_id' => $colSahara->id,
        'is_featured' => false,
        'is_new' => true,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/14.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Azure / Silver', 'color_hex' => '#38BDF8', 'stock' => 5],
            ['size' => 'L', 'color' => 'Azure / Silver', 'color_hex' => '#38BDF8', 'stock' => 7],
        ],
    ],
    [
        'name' => 'FORTUNES 2-PIECE ATELIER FLEECE TRACKSET',
        'slug' => 'fortunes-2-piece-atelier-fleece-trackset',
        'sku' => 'FC-TRK-020',
        'subtitle' => 'OUTERWEAR / TWO-PIECE',
        'short_description' => 'Heather grey 480 GSM zip hoodie and wide-leg sweatpants set with oval Fortunes embroidery.',
        'description' => 'Ultimate lounge opulence. Heavy diagonal fleece two-piece ensemble with double-lined hood, hidden ankle bungees, and deep hand-warming pockets.',
        'details' => "• 480 GSM Heavy French Terry\n• Two-piece zip hoodie and matching wide sweatpants\n• Embroidered oval insignias on chest and thigh\n• Elasticated waist with concealed thick drawcord",
        'care_instructions' => 'Machine wash cold. Line dry in shade.',
        'size_guide' => 'Oversized streetwear drape.',
        'price' => 310000.00,
        'compare_at_price' => 350000.00,
        'category_id' => $catOuterwear->id,
        'collection_id' => $colLekki->id,
        'is_featured' => true,
        'is_new' => true,
        'is_bestseller' => true,
        'status' => 'active',
        'featured_image' => '/img/2.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Heather Grey', 'color_hex' => '#9CA3AF', 'stock' => 9],
            ['size' => 'L', 'color' => 'Heather Grey', 'color_hex' => '#9CA3AF', 'stock' => 11],
        ],
    ],
    [
        'name' => 'FORTUNES RED PLAID ARTISAN OVERSHIRT',
        'slug' => 'fortunes-red-plaid-artisan-overshirt',
        'sku' => 'FC-SHT-021',
        'subtitle' => 'OUTERWEAR / OVERSHIRT',
        'short_description' => 'Cut-and-sew tartan plaid overshirt with cobweb rhinestone embellishments and mystic eye embroidery.',
        'description' => 'Intricate artisan craftsmanship. Features hand-pieced red tartan flannel blocks adorned with crystal rhinestone web motifs and embroidered patches.',
        'details' => "• 100% Brushed Cotton Flannel\n• Custom heat-set crystal rhinestone detailing\n• Gold snap buttons on front and cuffs\n• Back woven leather logo plaque",
        'care_instructions' => 'Dry clean only.',
        'size_guide' => 'Boxy jacket fit.',
        'price' => 260000.00,
        'compare_at_price' => 290000.00,
        'category_id' => $catOuterwear->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => false,
        'is_new' => true,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/13.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Crimson Tartan', 'color_hex' => '#B91C1C', 'stock' => 6],
            ['size' => 'L', 'color' => 'Crimson Tartan', 'color_hex' => '#B91C1C', 'stock' => 4],
        ],
    ],
    [
        'name' => 'FORTUNES DISTRESSED BELTED ATELIER JACKET',
        'slug' => 'fortunes-distressed-belted-atelier-jacket',
        'sku' => 'FC-JCK-022',
        'subtitle' => 'OUTERWEAR / RUNWAY PIECE',
        'short_description' => 'Textured bouclé wool-blend hooded jacket with integrated buckle belt and embroidered atelier graffiti.',
        'description' => 'Runway head-turner. Heavy mineral-washed bouclé knit with button front, generous hood, and attached utility web belt featuring cast metal buckle.',
        'details' => "• Heavy Textured Wool-Cotton Blend\n• Integrated web belt with antique metal hardware\n• Embroidered typographic art across back\n• Relaxed dropped shoulder silhouette",
        'care_instructions' => 'Specialist dry clean only.',
        'size_guide' => 'Oversized cocoon silhouette.',
        'price' => 365000.00,
        'compare_at_price' => null,
        'category_id' => $catOuterwear->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => false,
        'is_new' => true,
        'is_bestseller' => false,
        'status' => 'active',
        'featured_image' => '/img/19.webp',
        'variants' => [
            ['size' => 'M', 'color' => 'Earthy Mineral Patina', 'color_hex' => '#854D0E', 'stock' => 5],
            ['size' => 'L', 'color' => 'Earthy Mineral Patina', 'color_hex' => '#854D0E', 'stock' => 3],
        ],
    ],

    // ACCESSORIES
    [
        'name' => 'FORTUNES ATELIER CANVAS TOTE BAG',
        'slug' => 'fortunes-atelier-canvas-tote-bag',
        'sku' => 'FC-TOT-023',
        'subtitle' => 'ACCESSORIES / BAGS',
        'short_description' => 'Heavyweight 18oz natural ecru cotton canvas tote with embroidered orange insignia and reinforced handles.',
        'description' => 'Engineered for daily archive transport. Dense 18oz cotton canvas with reinforced box-stitch handles, woven side tag, and spacious interior gusset.',
        'details' => "• 18oz Heavy Organic Cotton Canvas\n• Embroidered citrus insignia and typography\n• Reinforced shoulder straps with cross-stitching\n• Interior zip pocket for phone and keys\n• Dimensions: 42cm x 38cm x 12cm",
        'care_instructions' => 'Spot clean with damp cloth.',
        'size_guide' => 'One Size.',
        'price' => 75000.00,
        'compare_at_price' => 90000.00,
        'category_id' => $catAccessories->id,
        'collection_id' => $colGenesis->id,
        'is_featured' => true,
        'is_new' => true,
        'is_bestseller' => true,
        'status' => 'active',
        'featured_image' => '/img/8.webp',
        'variants' => [
            ['size' => 'One Size', 'color' => 'Natural Ecru', 'color_hex' => '#FBF7EE', 'stock' => 30],
        ],
    ],
];

foreach ($newProducts as $data) {
    if (Product::where('slug', $data['slug'])->exists()) {
        continue;
    }

    $variants = $data['variants'];
    unset($data['variants']);

    $prod = Product::create($data);

    ProductImage::create([
        'product_id' => $prod->id,
        'image_path' => $prod->featured_image,
        'is_primary' => true,
        'alt_text' => $prod->name,
        'sort_order' => 1,
    ]);

    foreach ($variants as $v) {
        $sizeCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $v['size']), 0, 3));
        $colorCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $v['color']), 0, 3));
        $variant = ProductVariant::create([
            'product_id' => $prod->id,
            'size' => $v['size'],
            'color' => $v['color'],
            'color_hex' => $v['color_hex'],
            'sku' => $prod->sku . '-' . $sizeCode . '-' . $colorCode,
            'stock_quantity' => $v['stock'],
            'is_available' => $v['stock'] > 0,
        ]);

        Inventory::create([
            'product_id' => $prod->id,
            'product_variant_id' => $variant->id,
            'stock_count' => $v['stock'],
            'low_stock_threshold' => 5,
            'reserved_count' => 0,
        ]);
    }

    echo "Created new authentic product: {$prod->name} ({$prod->featured_image})\n";
}

echo "Sync completed successfully!\n";

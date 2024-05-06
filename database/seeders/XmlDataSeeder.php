<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class XmlDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xmlFile = public_path('products.xml'); // Ruta al archivo XML

        // Cargar el archivo XML
        $xml = simplexml_load_file($xmlFile);

        foreach ($xml->children() as $product) {           
            // Obtener el texto después de la última instancia del carácter ">"
            $lastGreaterThanPos = strrpos((string)$product->categoria, '>');
            $categoria = $lastGreaterThanPos !== false ? trim(substr((string)$product->categoria, $lastGreaterThanPos + 1)) : null;

            $insertData = [
                'id' => (int) $product->id,
                'categoria' => $categoria,
                'familia' => (string) $product->familia,
                'id_familia' => (int) $product->id_familia,
                'subfamilia' => (string) $product->subfamilia,
                'id_subfamilia' => (string) $product->id_subfamilia,
                'referencia' => (string) $product->referencia,
                'titulo' => substr((string) $product->titulo, 0, 255),
                'titulo_small' => (string) $product->titulo_small,
                'descripcion' => (string) $product->descripcion,
                'fabricante' => (string) $product->fabricante,
                'id_fabricante' => (string) $product->id_fabricante,
                'ean' => (string) $product->ean,
                'pn' => (string) $product->pn,
                'pvd' => (float) str_replace(',', '.', $product->pvd),
                'pvd_estandar' => (float) str_replace(',', '.', $product->pvd_estandar),
                'pvp' => (float) str_replace(',', '.', $product->pvp),
                'margen' => (float) str_replace(',', '.', $product->margen),
                'margen_pvp' => (float) str_replace(',', '.', $product->margen_pvp),
                'oferta' => (string) $product->oferta,
                'oferta_pvd' => (float) str_replace(',', '.', $product->oferta_pvd),
                'oferta_discount' => (float) str_replace(',', '.', $product->oferta_discount),
                'oferta_date_of' => (string) $product->oferta_date_of != '' ? (string) $product->oferta_date_of : null,
                'oferta_date_to' => (string) $product->oferta_date_to != '' ? (string) $product->oferta_date_to : null,
                'canon' => (float) str_replace(',', '.', $product->canon),
                'stock' => (int) $product->stock,
                'stockstatus' => (string) $product->stockstatus,
                'bajo_demanda' => (string) $product->bajo_demanda,
                'peso' => (float) str_replace(',', '.', $product->peso),
                'liquidacion' => (string) $product->liquidacion,
                'url_imagen' => (string) $product->url_imagen,
                'url_imagen_compress' => (string) $product->url_imagen_compress,
                'fecha_alta' => (string) $product->fecha_alta,
                'url_product' => (string) $product->url_product,
                'proveedor' => (string) $product->proveedor,
                'type_reduction' => (string) $product->type_reduction,
                'fam0' => (string) $product->fam0,
                'fam1' => (string) $product->fam1,
                'volumen' => (float) str_replace(',', '.', $product->volumen),
                'stock_disponible' => (int) $product->stock_disponible,
                'fecha_limite_unidades_hasta' => (string) $product->fecha_limite_unidades_hasta != '' ? (string) $product->fecha_limite_unidades_hasta : null,
                'created_at' => now(), 
                'updated_at' => now(),

            ];

            // Insertar los datos en la base de datos
            DB::table('products')->insert($insertData);
        }
    }
}
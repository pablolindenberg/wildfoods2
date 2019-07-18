<?php

namespace App\Exports;

use App\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PedidosExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $idusuario;
    public function __construct()
    {
    
       // $this->idusuario = $id; 
    }

    public function collection()
    {
        return Pedido::all();
       // return Pedido::where('idusuario',3);
       //return Pedido::where('idusuario',$this->idusuario)->get();
    }
    public function headings(): array
    {
        return [
            'ID Pedido',
            'ID usuario',
            'Total',
            'Tracking ID',
            'Estado',
            'Bodega',
            'Fecha ingreso',
            'Actualizado', 	
            
        ];
    }
}

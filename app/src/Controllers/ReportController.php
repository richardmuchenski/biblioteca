<?php

namespace App\Controllers;

use App\Models\ReportModel;

use Fpdf\Fpdf;

class ReportController {
    
    public function generatePDF() {
        requireRole('admin'); //somente admins podem gerar relatórios

        $pdf = new Fpdf();
        $pdf ->AddPage();
        $pdf ->SetFont('Arial','B',16);
        $pdf ->Cell(40,10,'Relatório de Empréstimos');


    }

    //Verificar se adicino mais funções de relatório, como gerar CSV, etc.
}


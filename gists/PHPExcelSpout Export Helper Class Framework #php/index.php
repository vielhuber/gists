<?php
namespace App\Helpers;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class ExportData {

    private $type;
    private $data;
    private $filename;
    private $font_size = 8;

    private $phpexcel_objPHPExcel;
    private $phpexcel_objWriter;

    private $spout_writer;

    function __construct() {

    }

    public function __get($name) {
        return $this->{$name};
    }

    public function __set($name, $value) {
        $this->{$name} = $value;
        if( $name == 'engine' ) {
            if( !in_array($this->engine, ['phpexcel','spout']) ) { die('wrong engine'); }
            if( $this->engine == 'phpexcel' ) {
                $this->phpexcel_objPHPExcel = new PHPExcel();
                $this->phpexcel_objPHPExcel->getDefaultStyle()->getFont()->setSize($this->font_size);
            }
            if( $this->engine == 'spout' ) {

            }
        }
        if( $name == 'type' ) {
            if( !in_array($this->type, ['xlsx','csv']) ) { die('wrong type'); }
            if( $this->engine == 'phpexcel' ) {
                if( $this->type == 'xlsx' ) {
                    $this->phpexcel_objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel_objPHPExcel,"Excel2007");
                }
                if( $this->type == 'csv' ) {
                    $this->phpexcel_objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel_objPHPExcel,"CSV");
                }
            }
            if( $this->engine == 'spout' ) {
                if( $this->type == 'xlsx' ) {
                    $this->spout_writer = WriterFactory::create(Type::XLSX);
                }
                if( $this->type == 'csv' ) {
                    $this->spout_writer = WriterFactory::create(Type::CSV);
                }
            }
        }
        if( $name == 'type' && $value == 'csv' ) {
            if( $this->engine == 'phpexcel' ) {
                $this->phpexcel_objWriter->setDelimiter(';');
                $this->phpexcel_objWriter->setEnclosure('"');
                $this->phpexcel_objWriter->setUseBOM(true);
                $this->phpexcel_objWriter->setPreCalculateFormulas(false);
            }
            if( $this->engine == 'spout' ) {
                $this->spout_writer->setFieldDelimiter('|');
                $this->spout_writer->setFieldEnclosure('@');
                $this->spout_writer->setEndOfLineCharacter("\r");
            }
        }
        if( $name == 'data' ) {
            if( $this->engine == 'phpexcel' ) {
                $this->phpexcel_objPHPExcel->getActiveSheet()->fromArray($value, NULL, 'A1');

                /* basic general configuration */

                // left align
                $this->phpexcel_objPHPExcel->getActiveSheet()->getStyle('A1:' . ($this->phpexcel_objPHPExcel->getActiveSheet()->getHighestColumn() . $this->phpexcel_objPHPExcel->getActiveSheet()->getHighestRow()))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                // first set columns to auto size
                $toCol = $this->phpexcel_objPHPExcel->getActiveSheet()->getColumnDimension($this->phpexcel_objPHPExcel->getActiveSheet()->getHighestColumn())->getColumnIndex();
                $toCol++;
                for ($i = "A"; $i !== $toCol; $i++) {
                    $this->phpexcel_objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
                }
                $this->phpexcel_objPHPExcel->getActiveSheet()->calculateColumnWidths();

                // increase columns by little padding
                $toCol = $this->phpexcel_objPHPExcel->getActiveSheet()->getColumnDimension($this->phpexcel_objPHPExcel->getActiveSheet()->getHighestColumn())->getColumnIndex();
                $toCol++;
                for ($i = "A"; $i !== $toCol; $i++) {
                    $calculatedWidth = $this->phpexcel_objPHPExcel->getActiveSheet()->getColumnDimension($i)->getWidth();
                    $this->phpexcel_objPHPExcel->getActiveSheet()->getColumnDimension($i)->setWidth((int)$calculatedWidth * 1.5)->setAutoSize(false);
                }
                $this->phpexcel_objPHPExcel->getActiveSheet()->calculateColumnWidths();
            }
            if( $this->engine == 'spout' ) {

            }
        }
    }

    public function formatTitle() {
        if( $this->engine == 'phpexcel' ) {
            $this->phpexcel_objPHPExcel->getActiveSheet()->getStyle("A1:" . $this->phpexcel_objPHPExcel->getActiveSheet()->getHighestColumn() . "1")->getFont()->setBold(true);
            $this->phpexcel_objPHPExcel->getActiveSheet()->getStyle("A1:" . $this->phpexcel_objPHPExcel->getActiveSheet()->getHighestColumn() . "1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->phpexcel_objPHPExcel->getActiveSheet()->getStyle("A1:" . $this->phpexcel_objPHPExcel->getActiveSheet()->getHighestColumn() . "1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->phpexcel_objPHPExcel->getActiveSheet()->getStyle("A1:" . $this->phpexcel_objPHPExcel->getActiveSheet()->getHighestColumn() . "1")->getAlignment()->setWrapText(true);
            $this->phpexcel_objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        }
    }

    public function download() {
        if( $this->filename === null ) { $this->filename = "export-".date('d.m.Y-H.i.s').".".$this->type; }
        if( $this->engine == 'phpexcel' ) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $this->filename . '"');
            $this->phpexcel_objWriter->save('php://output');
            die();
        }
        if( $this->engine == 'spout' ) {
            $this->spout_writer->openToBrowser($this->filename);
            $this->spout_writer->addRows($this->data);
            $this->spout_writer->close();
            die();
        }
    }

}
?>
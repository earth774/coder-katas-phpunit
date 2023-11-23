<?php

namespace App;

use Exception;

class StringCalculator
{
    /**
     * The maximum number allowed.
     */
    const MAX_NUMBER_ALLOWED = 1000;

    /**
     * The delimiter for the numbers.
     *
     * @var string
     */
    protected string $delimiter = ",|\n";

    /**
     * Add the provided set of numbers.
     *
     * @param  string  $numbers
     * @return int
     *
     * @throws \Exception
     */
    public function add(string $numbers)
    {
        $this->disallowNegatives($numbers = $this->parseString($numbers));

        return array_sum(
            $this->ignoreGreaterThan1000($numbers)
        );
    }

    /**
     * Parse the numbers string.
     *
     * @param  string  $numbers
     * @return array
     * 
     * คำจำกัดความของฟังก์ชัน: ฟังก์ชันนี้ถูกประกาศเป็น protected, หมายความว่ามันสามารถเข้าถึงได้ภายในคลาสนี้และคลาสลูก (subclasses) ของมัน ฟังก์ชันรับพารามิเตอร์เป็นสตริง $numbers และจะคืนค่าเป็นอาร์เรย์
     * กำหนดตัวกำหนด (Delimiter): ตัวแปร $customDelimiter ถูกกำหนดเป็นรูปแบบ regex ที่ใช้ในการค้นหาตัวกำหนดที่กำหนดโดยผู้ใช้ในสตริง $numbers รูปแบบนี้หมายถึงตัวอักขระใด ๆ ที่ตามหลังสัญลักษณ์ // และก่อนขึ้นบรรทัดใหม่ \n
     * การตรวจสอบและกำหนดตัวกำหนด: ฟังก์ชัน preg_match ใช้เพื่อตรวจสอบว่ารูปแบบ regex ที่กำหนดตรงกับส่วนใดๆ ในสตริง $numbers หรือไม่ ถ้าตรง, มันจะกำหนดตัวกำหนดใหม่ ($this->delimiter) ที่ตรวจพบและลบตัวกำหนดนั้นออกจากสตริง $numbers
     * แยกสตริงตามตัวกำหนด: สุดท้าย, preg_split ใช้เพื่อแยกสตริง $numbers ตามตัวกำหนดที่กำหนดไว้ หรือที่ตรวจพบจากขั้นตอนก่อนหน้านี้ ผลลัพธ์จะเป็นอาร์เรย์ที่ประกอบด้วยส่วนต่างๆ ของสตริงที่ถูกแยกจากกันโดยตัวกำหนดนั้น
     */
    protected function parseString(string $numbers): array
    {
        $customDelimiter = '\/\/(.)\n';

        if (preg_match("/{$customDelimiter}/", $numbers, $matches)) {
            $this->delimiter = $matches[1];

            $numbers = str_replace($matches[0], '', $numbers);
        }

        return preg_split("/{$this->delimiter}/", $numbers);
    }

    /**
     * Do not allow any negative numbers.
     *
     * @param  array  $numbers
     * @throws Exception
     */
    protected function disallowNegatives(array $numbers): void
    {
        foreach ($numbers as $number) {
            if ($number < 0) {
                throw new Exception('Negative numbers are disallowed.');
            }
        }
    }

    /**
     * Forget any number that is greater than 1,000.
     *
     * @param  array  $numbers
     * @return array
     */
    protected function ignoreGreaterThan1000(array $numbers): array
    {
        return array_filter(
            $numbers,
            fn ($number) => $number <= self::MAX_NUMBER_ALLOWED
        );
    }
}

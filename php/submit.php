<?php // $ cat sample | php php/submit.php

$paiza = new class extends Paiza implements PaizaInterface
{
    // メタデータ行数、あるいはサンプルデータ開始行位置
    protected $meta_lines = 0;

    /**
     * メタ行の取得   $meta[0], $meta[1], ...
     * データ行の取得 $data[0], $data[1], ...
     * 解答行の追加   $this->addResult(string)
     */
    public function process(array $meta, array $data)
    {
        // ここにコードを書く
    }
};

Paiza::submit($paiza);

class Paiza
{
    protected $result = [];

    static public function submit(PaizaInterface $paiza)
    {
        echo implode("\n", $paiza->result) . "\n";
    }

    // 多次元配列の生成
    static public function explode(array &$data, string $delimiter = ' ')
    {
        foreach ($data as $i => $v) {
            $data[$i] = explode($delimiter, $v);
        }
        return $data;
    }

    public function __construct()
    {
        if (STDIN) {
            ob_start();
            while (!feof(STDIN)) {
              echo trim(fgets(STDIN)).PHP_EOL;
            }
            $stdin = ob_get_clean();
        } else {
            $stdin = $this->sample;
        }

        $meta = [];
        $data = [];
        $stdin = str_replace(["\r\n", "\n\r"], "\n", $stdin);
        $lines = explode("\n", $stdin);
        for ($i = 0; $i < $this->meta_lines ?? 0; $i++) {
            $meta[] = array_shift($lines);
        }
        $this->process($meta, $lines);
    }

    public function addResult(string $output)
    {
        $this->result[] = $output;
        return $this;
    }
}

interface PaizaInterface
{
    public function process(array $meta, array $data);
}

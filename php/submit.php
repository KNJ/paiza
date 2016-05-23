<?php
/**
 * @author KNJ <knj@wazly.net>
 * @see    https://github.com/KNJ/paiza
 *
 * Do following command to test!
 * cat sample | php php/sumit.php
 */

$paiza = new class extends Paiza implements PaizaInterface
{
    // メタデータ行数、あるいはサンプルデータ開始行位置
    protected $meta_lines = 0;

    /**
     * メタ行の取得   $meta[0], $meta[1], ...
     * データ行の取得 $data[0], $data[1], ...
     * 解答行の追加   $this->add(string)
     */
    public function process(array $meta, array $data)
    {
        // ここにコードを書く
    }
};

Paiza::submit($paiza);

class Paiza
{
    public $result = [];

    /**
     * コードを提出
     */
    static public function submit(PaizaInterface $paiza)
    {
        echo implode("\n", $paiza->result) . "\n";
    }

    /**
     * 多次元配列の生成
     * Paiza::split($meta) // メタ行をスペースでさらに分割
     * Paiza::split($data) // データ行をスペースでさらに分割
     */
    static public function split(array &$data, string $delimiter = ' ')
    {
        foreach ($data as $i => $v) {
            $data[$i] = explode($delimiter, $v);
        }
        return $data;
    }

    /**
     * データ加工処理
     */
    public function __construct()
    {
        ob_start();
        while (!feof(STDIN)) {
          echo trim(fgets(STDIN)).PHP_EOL;
        }
        $stdin = ob_get_clean();

        $meta = [];
        $data = [];
        $stdin = str_replace(["\r\n", "\n\r"], "\n", $stdin);
        $stdin = rtrim($stdin);
        $lines = explode("\n", $stdin);
        for ($i = 0; $i < $this->meta_lines ?? 0; $i++) {
            $meta[] = array_shift($lines);
        }
        $this->process($meta, $lines);
    }

    /**
     * 出力行追加
     *
     * @return Paiza
     */
    public function add(string $output): Paiza
    {
        $this->result[] = $output;
        return $this;
    }
}

interface PaizaInterface
{
    public function process(array $meta, array $data);
}

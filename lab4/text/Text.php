<?php

class Text
{

    public static string $dir = "./text";

    /**
     * ReadFromFile читає і повертає вміст файлу
     *
     * @param string $file назва файлу
     * @return string|null повертає вміст файлу. Якщо файл не знайдено - повертає null
     */
    public static function ReadFromFile(string $file): ?string
    {
        $path = self::$dir . "/" . $file;
        if (is_file($path)) {
            return file_get_contents($path);
        }
        return null;
    }

    /**
     * WriteToFile дописує $content у файл $file
     *
     * @param string $file назва файлу
     * @param string $content контент, який потрібно дописати у файл
     * @return bool повертає true, якщо $content успішно додано і false якщо файл не знайдено
     */
    public static function WriteToFile(string $file, string $content): bool
    {
        $path = self::$dir . "/" . $file;
        if (is_file($path)) {
            file_put_contents($path, $content . "\n", FILE_APPEND);
            return true;
        }
        return false;
    }

    /**
     * ClearFile очищає вміст $file
     *
     * @param string $file назва файлу, який потрібно очистити
     * @return bool повертає true, якщо $file існує і його вміст було очищено і false якщо файл не знайдено
     */
    public static function ClearFile($file): bool
    {
        $path = self::$dir . "/" . $file;
        if (is_file($path)) {
            file_put_contents($path, "");
            return true;
        }
        return false;
    }
}
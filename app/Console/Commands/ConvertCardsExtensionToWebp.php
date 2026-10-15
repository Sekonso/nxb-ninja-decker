<?php

namespace App\Console\Commands;

use App\Models\Card;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('cards:webp {--dry-run : Tampilkan perubahan tanpa menyimpan ke database}')]
#[Description('Ubah ekstensi filename semua kartu menjadi .webp')]
class ConvertCardsExtensionToWebp extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Ekstensi tujuan
        $newExtension = 'webp';

        // Kumpulkan kartu yang perlu diubah
        $changes = [];

        foreach (Card::all() as $card) {
            $newFilename = $this->replaceExtension($card->filename, $newExtension);

            if ($newFilename !== $card->filename) {
                $changes[] = ['card' => $card, 'filename' => $newFilename];
            }
        }

        // Tidak ada perubahan
        if ($changes === []) {
            $this->components->info("Semua kartu sudah ber-ekstensi .{$newExtension}.");

            return self::SUCCESS;
        }

        // Mode preview
        if ($this->option('dry-run')) {
            foreach ($changes as $change) {
                $this->components->twoColumnDetail($change['card']->filename, $change['filename']);
            }

            $this->components->info(count($changes)." kartu akan diubah ke .{$newExtension}. (dry-run)");

            return self::SUCCESS;
        }

        // Simpan perubahan
        DB::transaction(function () use ($changes) {
            foreach ($changes as $change) {
                $change['card']->update(['filename' => $change['filename']]);
            }
        });

        $this->components->info(count($changes)." filename kartu berhasil diubah ke .{$newExtension}.");

        return self::SUCCESS;
    }

    /**
     * Ganti ekstensi file dengan ekstensi baru.
     */
    private function replaceExtension(string $filename, string $newExtension): string
    {
        $baseName = pathinfo($filename, PATHINFO_FILENAME);

        return $baseName.'.'.$newExtension;
    }
}

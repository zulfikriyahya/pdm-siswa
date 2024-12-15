<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Models\Siswa;
use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\SiswaResource;
use Filament\Resources\Pages\ListRecords;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {

        if (Auth::check()) {
            $user = Auth::user();
            $siswa = Siswa::where('nisn', $user->username)->first();
            $url = '';
            $status_verval = '';

            if ($siswa) {
                $name = $siswa->nama;
                $url = "/admin/siswas/{$siswa->id}/edit";
                $status_verval = $siswa->status_verval == false;
            } else {
                $name = $user->name;
            }
        }
        return [
            Actions\CreateAction::make()
                ->visible(Auth::user()->is_admin === 'Administrator'),
            Action::make('Verval Data')
                ->label("VERIFIKASI $name")
                ->icon('heroicon-m-check-badge')
                ->url($url)
                ->color('danger')
                ->visible($status_verval && $user->is_active === true)
                ->hidden(Auth::user()->is_admin === 'Administrator')
                ->successRedirectUrl('/admin/siswas')
        ];
    }
}

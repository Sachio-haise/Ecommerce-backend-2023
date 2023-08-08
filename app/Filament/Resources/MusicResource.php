<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusicResource\Pages;
use App\Filament\Resources\MusicResource\RelationManagers;
use App\Filament\Tables\Columns\S3ImageColumn;
use App\Models\Music;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;

class MusicResource extends Resource
{
    protected static ?string $model = Music::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Title')->required(),
                        Forms\Components\TextInput::make('description')->label('Description')->required(),
                        Forms\Components\TextInput::make('artist')->label('Artist')->required(),
                        Forms\Components\FileUpload::make('source')->label('Upload Track')->disk('s3')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return (string) str($file->getClientOriginalName())->prepend('track-');
                            })
                            ->directory('track')
                            ->visibility('private')->required(),
                        Forms\Components\FileUpload::make('cover_art')->label('Upload Cover')->disk('s3')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return (string) str($file->getClientOriginalName())->prepend('cover-');
                            })
                            ->directory('cover-art')
                            ->visibility('private')->required()
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->label('Description'),
                Tables\Columns\TextColumn::make('artist')->label('Artist'),
                S3ImageColumn::make('source')->label('Track'),
                S3ImageColumn::make('cover_art')->label('Cover'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMusic::route('/'),
            'create' => Pages\CreateMusic::route('/create'),
            'edit' => Pages\EditMusic::route('/{record}/edit'),
        ];
    }
}

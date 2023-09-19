<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Field;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;
use App\Filament\Tables\Columns\S3ImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'title'),
                    Forms\Components\TextInput::make('title')->label('Product Name')->required(),
                    Forms\Components\TextInput::make('description')->label('Product Description')->required(),
                    Forms\Components\TextInput::make('price')->label('Product Price')->required(),

                    Forms\Components\TextInput::make('quantity')->label('Product Quantity')->required(),
                    Forms\Components\TextInput::make('discount')->label('Product Discount')->required(),
                    Forms\Components\Select::make('size')
                        ->label('Product Size')
                        ->options(['sm', 'md', 'lg'])
                        ->searchable(),

                    Forms\Components\FileUpload::make('image')->label('Image')->disk('s3')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend('product-');
                        })
                        ->directory('products')
                        ->visibility('private')->required(),
                ])->columns(2),


                Forms\Components\Section::make('Gallery')
                    ->schema([
                        Forms\Components\FileUpload::make('gallery')
                            ->disk('s3')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return (string) str($file->getClientOriginalName())->prepend('product-gallery-');
                            })
                            ->multiple()
                            ->directory('products-gallery')
                            ->minFiles(0)
                            ->maxFiles(6)
                            ->visibility('public')
                            ->imagePreviewHeight('150')
                            ->imageCropAspectRatio('1:1')
                            ->maxFiles(10)
                            ->disableLabel(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Product Name'),
                Tables\Columns\TextColumn::make('description')->label('Description'),
                Tables\Columns\TextColumn::make('price')->label('Price'),
                Tables\Columns\TextColumn::make('quantity')->label('Quantity'),
                Tables\Columns\TextColumn::make('discount')->label('Discount'),
                S3ImageColumn::make('image')->label('Image'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

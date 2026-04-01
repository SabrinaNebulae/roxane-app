<?php

namespace App\Filament\Resources\NotificationTemplates\Schemas;

use App\Models\NotificationTemplate;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NotificationTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(fn (?NotificationTemplate $record) => $record?->name ?? NotificationTemplate::getAttributeLabel('name'))
                    ->afterHeader([
                        Toggle::make('is_active')
                            ->label(NotificationTemplate::getAttributeLabel('is_active'))
                            ->default(true),
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label(NotificationTemplate::getAttributeLabel('name'))
                            ->required(),
                        TextInput::make('identifier')
                            ->label(NotificationTemplate::getAttributeLabel('identifier'))
                            ->required()
                            ->disabledOn('edit'),
                        TextInput::make('subject')
                            ->label(NotificationTemplate::getAttributeLabel('subject'))
                            ->required()
                            ->helperText(fn (?NotificationTemplate $record) => $record?->variables
                                ? NotificationTemplate::getAttributeLabel('variables').' : '.implode(', ', array_map(fn ($k) => '{'.$k.'}', array_keys($record->variables)))
                                : null),
                        RichEditor::make('body')
                            ->label(NotificationTemplate::getAttributeLabel('body'))
                            ->required()
                            ->helperText(fn (?NotificationTemplate $record) => $record?->variables
                                ? NotificationTemplate::getAttributeLabel('variables').' : '.implode(', ', array_map(fn ($k) => '{'.$k.'}', array_keys($record->variables)))
                                : null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

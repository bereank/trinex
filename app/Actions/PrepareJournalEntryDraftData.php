<?php

namespace App\Actions;

use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PrepareJournalEntryDraftData
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(array $data): array
    {
        // $clientIds = UserDatabase::query()
        //     ->where('user_id', auth()->id())
        //     ->pluck('client_id');

        $validated = Validator::make($data, [

            'reference_1' => ['nullable', 'string', 'max:100'],
            'reference_2' => ['nullable', 'string', 'max:100'],
            'reference_3' => ['nullable', 'string', 'max:100'],
            'series' => ['required', 'string', 'max:100'],
            'currency' => ['required', 'string', 'max:10'],
            'exchange_rate' => ['required', 'numeric', 'gt:0'],
            'posting_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date'],
            'document_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string', 'max:1000'],
            'lines' => ['required', 'array', 'min:2', 'max:100'],
            'lines.*.account_code' => ['required', 'string', 'max:50'],
            'lines.*.account_name' => ['nullable', 'string', 'max:200'],
            'lines.*.debit' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'lines.*.credit' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'lines.*.debit_fc' => ['nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'lines.*.credit_fc' => ['nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'lines.*.cost_code_1' => ['nullable', 'string', 'max:50'],
            'lines.*.cost_code_2' => ['nullable', 'string', 'max:50'],
            'lines.*.cost_code_3' => ['nullable', 'string', 'max:50'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['string'],
        ])->validate();

        $clientId = 1001;
        $userDirectory = 'journal-entry-drafts/'.auth()->id().'/';
        foreach ($validated['attachments'] ?? [] as $path) {
            if (
                str_contains($path, '..')
                || ! str_starts_with($path, $userDirectory)
                || ! Storage::disk('local')->exists($path)
            ) {
                throw ValidationException::withMessages([
                    'data.attachments' => 'One or more attachments are invalid. Please upload them again.',
                ]);
            }
        }

        $accountCodes = collect($validated['lines'])->pluck('account_code')->unique()->all();
        $accounts = ChartOfAccount::query()
            ->whereNotNull('AcctCode')
            ->whereIn('AcctCode', $accountCodes)
            ->get(['AcctCode', 'AcctName'])
            ->keyBy('AcctCode');

        $debitTotalInCents = 0;
        $creditTotalInCents = 0;
        $lines = array_values($validated['lines']);

        foreach ($lines as $index => &$line) {
            $account = $accounts->get($line['account_code']);

            if (! $account instanceof ChartOfAccount) {
                throw ValidationException::withMessages([
                    "data.lines.{$index}.account_code" => 'Select a valid G/L or BP code.',
                ]);
            }

            $line['account_name'] = $account->AcctName;
            $debitInCents = (int) round((float) $line['debit'] * 100);
            $creditInCents = (int) round((float) $line['credit'] * 100);
            if (($debitInCents <= 0 && $creditInCents <= 0) || ($debitInCents > 0 && $creditInCents > 0)) {
                throw ValidationException::withMessages([
                    "data.lines.{$index}.debit" => 'Enter either a debit or a credit amount for each line.',
                ]);
            }

            $debitTotalInCents += $debitInCents;
            $creditTotalInCents += $creditInCents;
        }
        unset($line);

        if ($debitTotalInCents !== $creditTotalInCents) {
            throw ValidationException::withMessages([
                'data.lines' => 'Total debits must equal total credits.',
            ]);
        }

        return [
            ...$validated,
            'client_id' => $clientId,
            'lines' => $lines,
            'attachments' => array_values($validated['attachments'] ?? []),
        ];
    }
}

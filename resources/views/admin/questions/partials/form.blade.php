<div class="space-y-6">
    <div class="space-y-1.5">
        <label for="evaluation_form_id" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Formulir Evaluasi</label>
        <select id="evaluation_form_id" name="evaluation_form_id" required autofocus>
            <option value="">Pilih Formulir</option>
            @foreach($forms as $form)
                <option value="{{ $form->id }}" {{ old('evaluation_form_id', ($question ?? null)?->evaluation_form_id ?? request('evaluation_form_id')) == $form->id ? 'selected' : '' }}>
                    {{ $form->title }} ({{ $form->evaluationPeriod->name }})
                </option>
            @endforeach
        </select>
        <x-ui.error name="evaluation_form_id" />
    </div>

    <div class="space-y-1.5">
        <label for="question_category_id" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Kategori</label>
        <select id="question_category_id" name="question_category_id" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('question_category_id', ($question ?? null)?->question_category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-ui.error name="question_category_id" />
    </div>

    <div class="space-y-1.5">
        <label for="question_text" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Teks Pertanyaan</label>
        <textarea id="question_text" name="question_text" rows="3" required placeholder="Contoh: Apakah materi perkuliahan mudah dipahami?">{{ old('question_text', ($question ?? null)?->question_text) }}</textarea>
        <x-ui.error name="question_text" />
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div class="space-y-1.5">
            <label for="sort_order" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Urutan Tampil</label>
            <input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', ($question ?? null)?->sort_order ?? 1) }}" required>
            <x-ui.error name="sort_order" />
        </div>

        <div class="flex items-end pb-2.5">
            <div class="flex items-center">
                <input type="hidden" name="is_required" value="0">
                <input id="is_required" name="is_required" type="checkbox" value="1" {{ old('is_required', ($question ?? null)?->is_required ?? true) ? 'checked' : '' }}>
                <label for="is_required" class="ml-3 text-sm font-medium text-zinc-950 text-xs font-bold uppercase tracking-wider">Wajib Diisi</label>
            </div>
        </div>
    </div>
</div>

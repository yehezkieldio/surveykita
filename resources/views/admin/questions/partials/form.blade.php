<div class="grid gap-5">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="grid gap-1">
            <label for="evaluation_form_id" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Form Evaluasi</label>
            <select 
                id="evaluation_form_id" 
                name="evaluation_form_id" 
                class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
                required
            >
                @foreach ($forms as $form)
                    <option value="{{ $form->id }}" @selected((int) old('evaluation_form_id', $question?->evaluation_form_id) === $form->id)>{{ $form->title }}</option>
                @endforeach
            </select>
            <x-form-error name="evaluation_form_id" />
        </div>

        <div class="grid gap-1">
            <label for="question_category_id" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Kategori</label>
            <select 
                id="question_category_id" 
                name="question_category_id" 
                class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
                required
            >
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('question_category_id', $question?->question_category_id) === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <x-form-error name="question_category_id" />
        </div>
    </div>

    <div class="grid gap-1">
        <label for="question_text" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Butir Teks Pertanyaan</label>
        <textarea 
            id="question_text" 
            name="question_text" 
            rows="3" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none"
            required
        >{{ old('question_text', $question?->question_text) }}</textarea>
        <x-form-error name="question_text" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="grid gap-1">
            <label for="sort_order" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Urutan Tampil (Sort Order)</label>
            <input 
                id="sort_order" 
                name="sort_order" 
                type="number" 
                min="0" 
                value="{{ old('sort_order', $question?->sort_order ?? 0) }}" 
                class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
                required
            >
            <x-form-error name="sort_order" />
        </div>

        <div class="flex items-center gap-2 sm:mt-6">
            <input type="hidden" name="is_required" value="0">
            <input 
                id="is_required" 
                name="is_required" 
                type="checkbox" 
                value="1" 
                @checked(old('is_required', $question?->is_required ?? true)) 
                class="rounded-none border-zinc-300 text-zinc-950 focus:ring-zinc-950 focus:ring-offset-0"
            >
            <label for="is_required" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Wajib Dijawab Responden</label>
        </div>
    </div>
</div>

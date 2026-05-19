{{--
    Formulaire contact (réutilisable : page Contact + accueil judo.blade).
    - idSuffix : suffixe des id HTML pour éviter les doublons (ex. '_home').
--}}
@php($suffix = $idSuffix ?? '')

<div class="contact-page-form-panel rounded-4 shadow-sm p-4 p-xl-5 h-100">
    <form action="{{ route('contact.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="row g-3 mb-1">
            <div class="col-md-6">
                <label for="contact_email{{ $suffix }}" class="visually-hidden">Email</label>
                <input type="email"
                       id="contact_email{{ $suffix }}"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       maxlength="255"
                       autocomplete="email"
                       placeholder="Email *"
                       class="form-control form-control-lg shadow-sm border-0 @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="contact_name{{ $suffix }}" class="visually-hidden">Nom</label>
                <input type="text"
                       id="contact_name{{ $suffix }}"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       maxlength="255"
                       autocomplete="name"
                       placeholder="Nom complet *"
                       class="form-control form-control-lg shadow-sm border-0 @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="contact_phone{{ $suffix }}" class="visually-hidden">Téléphone</label>
            <input type="tel"
                   id="contact_phone{{ $suffix }}"
                   name="phone"
                   value="{{ old('phone') }}"
                   maxlength="50"
                   autocomplete="tel"
                   placeholder="Téléphone (optionnel)"
                   class="form-control form-control-lg shadow-sm border-0 @error('phone') is-invalid @enderror">
            @error('phone')
                <div class="invalid-feedback d-block small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="contact_sujet{{ $suffix }}" class="visually-hidden">Sujet</label>
            <input type="text"
                   id="contact_sujet{{ $suffix }}"
                   name="sujet"
                   value="{{ old('sujet') }}"
                   required
                   maxlength="255"
                   placeholder="Sujet *"
                   class="form-control form-control-lg shadow-sm border-0 @error('sujet') is-invalid @enderror">
            @error('sujet')
                <div class="invalid-feedback d-block small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="contact_message{{ $suffix }}" class="visually-hidden">Message</label>
            <textarea id="contact_message{{ $suffix }}"
                      name="message"
                      rows="6"
                      required
                      maxlength="2000"
                      placeholder="Message *"
                      class="form-control form-control-lg shadow-sm border-0 @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
            @error('message')
                <div class="invalid-feedback d-block small">{{ $message }}</div>
            @enderror
            <span class="form-text small text-muted">maximum 2000 caractères</span>
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100 text-uppercase fw-bold py-3 rounded-3 shadow-sm border-0">
            Envoyer le message
        </button>
    </form>
</div>

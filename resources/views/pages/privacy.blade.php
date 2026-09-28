@extends('layouts.app')

@section('title', 'Privacy Policy — Wuba 58 City Models')
@section('description', 'How Wuba 58 City Models collects, uses, and protects your data.')

@section('content')

<x-page-hero
    label="Legal"
    title="Privacy Policy"
    description="How we collect, use, and protect information on this website."
/>

<x-section>
    <div class="max-w-3xl mx-auto prose prose-invert prose-lg
                prose-headings:font-display prose-headings:tracking-tightest prose-headings:uppercase prose-headings:text-cream-100
                prose-p:text-charcoal-200 prose-p:leading-relaxed
                prose-a:text-gold-400 hover:prose-a:underline
                prose-strong:text-cream-100
                prose-li:text-charcoal-200">

        <h2>Information we collect</h2>
        <p>When you submit our contact form, we collect the information you provide: name, email address, phone number, company, and message content. We also log your IP address and browser user agent for security and abuse prevention.</p>

        <h2>How we use your information</h2>
        <p>We use the information you provide to respond to your enquiry, provide quotations, and deliver services. We do not sell, rent, or share your information with third parties except as required by law or as necessary to deliver our services.</p>

        <h2>Analytics</h2>
        <p>We may use cookies and analytics tools to understand how visitors use our website. Analytics data is aggregated and anonymised. You can decline cookies using the banner shown on your first visit.</p>

        <h2>Cookies</h2>
        <p>This website uses essential cookies to maintain your session and CSRF protection. If you consent, we also use analytics cookies to improve the site. You can clear cookies at any time in your browser settings.</p>

        <h2>Data retention</h2>
        <p>Contact form submissions are retained for as long as necessary to serve your enquiry and any resulting engagement. Analytics data is retained for up to 12 months.</p>

        <h2>Your rights</h2>
        <p>Under Kenya's Data Protection Act (2019), you have the right to access, correct, or delete your personal data. Contact us at <a href="mailto:{{ \App\Models\Setting::get('contact.email') }}">{{ \App\Models\Setting::get('contact.email') }}</a> to exercise these rights.</p>

        <h2>Changes to this policy</h2>
        <p>We may update this policy from time to time. The latest version is always available at this URL.</p>

        <p><em>Last updated: {{ date('F j, Y') }}</em></p>
    </div>
</x-section>

@endsection
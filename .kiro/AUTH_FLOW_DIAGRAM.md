# 🔐 Diagram Alur Autentikasi Perpustakaan Kota Sumbawa

## Arsitektur Sistem Autentikasi

```
┌─────────────────────────────────────────────────────────────────┐
│                    SISTEM PERPUSTAKAAN                          │
│                                                                 │
│  Public Access          Auth Required        Staff Only        │
│  ─────────────         ──────────────        ───────────       │
│  • Home (/)             • /profil-saya       • /dashboard       │
│  • /buku                • /peminjaman-saya                      │
│  • /rak-buku                                                    │
└─────────────────────────────────────────────────────────────────┘
```

---

## 1. Flow Diagram: REGISTER

```
┌──────────┐
│  Guest   │
│  User    │
└────┬─────┘
     │
     │ GET /register
     ↓
┌────────────────────────────────────┐
│  RegisterController                │
│  @showRegistrationForm             │
│                                    │
│  return view('auth.register')      │
└────────────┬───────────────────────┘
             │
             │ View: Form Register
             │
    ┌────────┴─────────┐
    │ User mengisi:    │
    │ • name           │
    │ • email          │
    │ • password       │
    │ • role           │
    │                  │
    │ Jika pelajar:    │
    │ • nim_nis        │
    │ • asal_sekolah   │
    │                  │
    │ Jika non_pelajar:│
    │ • nik            │
    │ • pekerjaan      │
    └────────┬─────────┘
             │
             │ POST /register
             ↓
┌─────────────────────────────────────────────┐
│  RegisterController@register                │
│                                             │
│  1. Validasi input dasar                    │
│  2. Validasi tambahan by role               │
│  3. DB::transaction()                       │
│     ├─ Create User                          │
│     ├─ Generate no_anggota                  │
│     ├─ Create AnggotaPelajar/NonPelajar    │
│     └─ Create Notification                  │
│  4. Auth::login($user)                      │
│  5. Redirect ke home                        │
└────────────┬────────────────────────────────┘
             │
             ↓
    ┌────────────────┐
    │ User logged in │
    │ Redirect: /    │
    └────────────────┘
```

---

## 2. Flow Diagram: LOGIN

```
┌──────────┐
│  Guest   │
│  User    │
└────┬─────┘
     │
     │ GET /login
     ↓
┌────────────────────────────────────┐
│  LoginController                   │
│  @showLoginForm                    │
│                                    │
│  return view('auth.login')         │
└────────────┬───────────────────────┘
             │
             │ View: Form Login
             │
    ┌────────┴─────────┐
    │ User mengisi:    │
    │ • email          │
    │ • password       │
    │ • remember (opt) │
    └────────┬─────────┘
             │
             │ POST /login
             ↓
┌─────────────────────────────────────────────┐
│  LoginController@login                      │
│                                             │
│  1. Validate credentials                    │
│  2. Auth::attempt($credentials, $remember)  │
│     ├─ Success? Continue                    │
│     └─ Failed? Return error                 │
│  3. $request->session()->regenerate()       │
│  4. Check user role:                        │
│     ├─ superadmin/petugas → /dashboard      │
│     └─ pelajar/non_pelajar → /              │
└────────────┬────────────────────────────────┘
             │
      ┌──────┴──────┐
      │             │
      ↓             ↓
┌──────────┐  ┌────────────┐
│Dashboard │  │   Home     │
│(Staff)   │  │  (Member)  │
└──────────┘  └────────────┘
```

---

## 3. Flow Diagram: LOGOUT

```
┌──────────────┐
│ Logged User  │
└──────┬───────┘
       │
       │ Click Logout Button
       │ POST /logout
       ↓
┌────────────────────────────────────┐
│  LoginController@logout            │
│                                    │
│  1. Auth::logout()                 │
│  2. $request->session()            │
│     ->invalidate()                 │
│  3. $request->session()            │
│     ->regenerateToken()            │
│  4. Redirect to home               │
└────────────┬───────────────────────┘
             │
             ↓
    ┌────────────────┐
    │ Guest (logout) │
    │ Redirect: /    │
    └────────────────┘
```

---

## 4. Middleware Flow: CheckRole

```
┌──────────────┐
│   Request    │
└──────┬───────┘
       │
       ↓
┌────────────────────────────────────┐
│  CheckRole Middleware              │
│                                    │
│  1. User logged in?                │
│     └─ No → redirect('/login')     │
│                                    │
│  2. User role = 'superadmin'?      │
│     └─ Yes → Allow ALL routes      │
│                                    │
│  3. User role in allowed roles?    │
│     ├─ Yes → Allow access          │
│     └─ No → abort(403)             │
└────────────┬───────────────────────┘
             │
      ┌──────┴──────┐
      │             │
      ↓             ↓
┌──────────┐  ┌────────────┐
│  Allow   │  │  Forbidden │
│  Access  │  │    403     │
└──────────┘  └────────────┘
```

---

## 5. Role Permission Matrix

```
┌──────────────┬────────┬─────────┬──────────┬──────────────┐
│   Route      │ Guest  │ Pelajar │ Non-Pel  │ Staff/Admin  │
├──────────────┼────────┼─────────┼──────────┼──────────────┤
│ /            │   ✅   │   ✅    │    ✅    │      ✅      │
│ /buku        │   ✅   │   ✅    │    ✅    │      ✅      │
│ /rak-buku    │   ✅   │   ✅    │    ✅    │      ✅      │
├──────────────┼────────┼─────────┼──────────┼──────────────┤
│ /login       │   ✅   │   ❌    │    ❌    │      ❌      │
│ /register    │   ✅   │   ❌    │    ❌    │      ❌      │
├──────────────┼────────┼─────────┼──────────┼──────────────┤
│ /logout      │   ❌   │   ✅    │    ✅    │      ✅      │
├──────────────┼────────┼─────────┼──────────┼──────────────┤
│ /profil-saya │   ❌   │   ✅    │    ✅    │      ❌      │
│ /peminjaman  │   ❌   │   ✅    │    ✅    │      ❌      │
├──────────────┼────────┼─────────┼──────────┼──────────────┤
│ /dashboard   │   ❌   │   ❌    │    ❌    │      ✅      │
└──────────────┴────────┴─────────┴──────────┴──────────────┘
```

---

## 6. Database Schema: Tabel Users & Anggota

```
┌─────────────────────────────────────────────┐
│              users                          │
├─────────────────────────────────────────────┤
│ id                  (PK)                    │
│ name                VARCHAR(100)            │
│ email               VARCHAR(100) UNIQUE     │
│ password            VARCHAR(255)            │
│ role                ENUM(pelajar, non_pe... │
│ email_verified_at   TIMESTAMP NULL          │
│ remember_token      VARCHAR(100) NULL       │
│ created_at          TIMESTAMP               │
│ updated_at          TIMESTAMP               │
└─────────────────────────────────────────────┘
                     │
         ┌───────────┴──────────┐
         │                      │
         ↓                      ↓
┌──────────────────┐   ┌──────────────────┐
│ anggota_pelajar  │   │anggota_non_pel.. │
├──────────────────┤   ├──────────────────┤
│ id          (PK) │   │ id          (PK) │
│ user_id     (FK) │   │ user_id     (FK) │
│ no_anggota       │   │ no_anggota       │
│ nim_nis          │   │ nik              │
│ nama_anggota     │   │ nama_anggota     │
│ asal_sekolah     │   │ pekerjaan        │
│ tgl_daftar       │   │ tgl_daftar       │
│ ...              │   │ ...              │
└──────────────────┘   └──────────────────┘
```

---

## 7. Session & Security Flow

```
┌─────────────────────────────────────────────────────────┐
│                  Security Measures                       │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  1. Session Management:                                  │
│     • session()->regenerate() after login               │
│     • session()->invalidate() on logout                 │
│     • session()->regenerateToken() on logout            │
│                                                          │
│  2. Password Security:                                   │
│     • Hash::make() for storing                          │
│     • Auth::attempt() for verification                  │
│     • Minimum 8 characters                              │
│                                                          │
│  3. CSRF Protection:                                     │
│     • @csrf token in all forms                          │
│     • Automatic validation by Laravel                   │
│                                                          │
│  4. Middleware Protection:                               │
│     • guest: Only unauthenticated                       │
│     • auth: Only authenticated                          │
│     • roles: Role-based access control                  │
│                                                          │
│  5. Remember Me:                                         │
│     • Optional checkbox in login                        │
│     • 2 weeks persistent session                        │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## 8. Error Handling Flow

```
┌─────────────────────────────────────────────────┐
│         Common Authentication Errors            │
├─────────────────────────────────────────────────┤
│                                                 │
│  1. Invalid Credentials:                        │
│     → LoginController returns with error        │
│     → Message: "Email atau password salah"      │
│     → User stays on login page                  │
│                                                 │
│  2. Validation Failed:                          │
│     → Laravel validation returns errors         │
│     → Form shows field-specific errors          │
│     → Previous input is preserved               │
│                                                 │
│  3. Unauthorized Access (403):                  │
│     → CheckRole middleware aborts               │
│     → Message: "Tidak memiliki hak akses"       │
│     → Shows 403 error page                      │
│                                                 │
│  4. Unauthenticated (401):                      │
│     → Auth middleware redirects                 │
│     → Redirect to: /login                       │
│     → Intended URL is saved for redirect        │
│                                                 │
└─────────────────────────────────────────────────┘
```

---

## 9. Controller Method Overview

```
┌─────────────────────────────────────────────────────────┐
│              Auth Controllers                            │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  LoginController:                                        │
│  ├─ showLoginForm()  → Show login view                  │
│  ├─ login()          → Process login                    │
│  └─ logout()         → Process logout                   │
│                                                          │
│  RegisterController:                                     │
│  ├─ showRegistrationForm() → Show register view         │
│  └─ register()             → Process registration       │
│                                                          │
│  ForgotPasswordController:                               │
│  ├─ showLinkRequestForm()  → Show forgot password       │
│  ├─ sendResetLinkEmail()   → Send reset link           │
│  ├─ showResetForm()        → Show reset password        │
│  └─ reset()                → Process password reset     │
│                                                          │
├─────────────────────────────────────────────────────────┤
│              Other Controllers                           │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  HomeController:                                         │
│  └─ __invoke()       → Show home page                   │
│                                                          │
│  DashboardController:                                    │
│  ├─ index()          → Show dashboard (staff)           │
│  ├─ profilAnggota()  → Show member profile              │
│  └─ peminjamanSaya() → Show member loan history         │
│                                                          │
│  BukuController:                                         │
│  ├─ index()          → Show book catalog                │
│  └─ rakBuku()        → Show book shelf view             │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## 10. Quick Reference: Routes

```bash
# Public Routes
GET  /                     → HomeController (Home page)
GET  /buku                 → BukuController@index (Catalog)
GET  /rak-buku             → BukuController@rakBuku (Shelf)

# Guest Only Routes (middleware: guest)
GET  /login                → LoginController@showLoginForm
POST /login                → LoginController@login
GET  /register             → RegisterController@showRegistrationForm
POST /register             → RegisterController@register
GET  /forgot-password      → ForgotPasswordController@showLinkRequestForm
POST /forgot-password      → ForgotPasswordController@sendResetLinkEmail
GET  /reset-password/{token} → ForgotPasswordController@showResetForm
POST /reset-password       → ForgotPasswordController@reset

# Auth Only Routes (middleware: auth)
POST /logout               → LoginController@logout

# Member Routes (middleware: auth, roles:pelajar,non_pelajar)
GET  /profil-saya          → DashboardController@profilAnggota
GET  /peminjaman-saya      → DashboardController@peminjamanSaya

# Staff Routes (middleware: auth, roles:superadmin,petugas)
GET  /dashboard            → DashboardController@index
```

---

**Dokumentasi ini menjelaskan alur lengkap autentikasi sistem perpustakaan.**  
Untuk detail implementasi, lihat file controller dan routes terkait.

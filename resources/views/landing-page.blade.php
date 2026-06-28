                                                <!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Studio - Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#ffffff',
                        foreground: '#09090b',
                        muted: '#f4f4f5',
                        'muted-foreground': '#71717a',
                        primary: '#18181b',
                        'primary-foreground': '#fafafa',
                        accent: '#f4f4f5',
                        border: '#e4e4e7'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-background via-background to-muted/20 text-foreground font-sans antialiased" x-data="{ isMenuOpen: false, scrollY: 0 }" @scroll.window="scrollY = window.scrollY">
    <div class="flex min-h-screen flex-col">
        <!-- Header -->
        <header :class="{ 'shadow-md': scrollY > 50 }" class="sticky top-0 z-50 w-full border-b border-border bg-background/95 backdrop-blur transition-all duration-300">
            <div class="container mx-auto max-w-7xl px-4 flex h-16 items-center justify-between border-x border-border">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="h-10 w-10 rounded-3xl bg-primary flex items-center justify-center transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                            <i data-lucide="sparkles" class="h-5 w-5 text-primary-foreground"></i>
                        </div>
                        <span class="font-bold text-xl">Studio</span>
                    </a>
                </div>
                <nav class="hidden md:flex gap-6">
                    <a href="#services" class="text-sm font-medium transition-colors hover:text-gray-500">Services</a>
                    <a href="#work" class="text-sm font-medium transition-colors hover:text-gray-500">Work</a>
                    <a href="#about" class="text-sm font-medium transition-colors hover:text-gray-500">About</a>
                    <a href="#clients" class="text-sm font-medium transition-colors hover:text-gray-500">Clients</a>
                    <a href="#contact" class="text-sm font-medium transition-colors hover:text-gray-500">Contact</a>
                </nav>
                <div class="hidden md:flex items-center gap-3">
                    <button class="inline-flex items-center justify-center rounded-3xl border border-border bg-transparent px-4 py-2 text-sm font-medium shadow-sm hover:bg-accent hover:text-foreground transition-colors">
                        Log In
                    </button>
                    <button class="inline-flex items-center justify-center rounded-3xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow hover:bg-primary/90 transition-colors">
                        Get Started
                    </button>
                </div>
                <button class="flex md:hidden" @click="isMenuOpen = !isMenuOpen">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                    <span class="sr-only">Toggle menu</span>
                </button>
            </div>
        </header>

        <!-- Mobile Menu -->
        <div x-cloak x-show="isMenuOpen" x-transition.opacity class="fixed inset-0 z-50 bg-background md:hidden">
            <div class="container mx-auto px-4 flex h-16 items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-3xl bg-primary flex items-center justify-center">
                            <i data-lucide="sparkles" class="h-5 w-5 text-primary-foreground"></i>
                        </div>
                        <span class="font-bold text-xl">Studio</span>
                    </a>
                </div>
                <button @click="isMenuOpen = false">
                    <i data-lucide="x" class="h-6 w-6"></i>
                    <span class="sr-only">Close menu</span>
                </button>
            </div>
            <nav class="container mx-auto px-4 grid gap-3 pb-8 pt-6">
                <a href="#services" @click="isMenuOpen = false" class="flex items-center justify-between rounded-3xl px-3 py-2 text-lg font-medium hover:bg-accent transition-colors">Services <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="#work" @click="isMenuOpen = false" class="flex items-center justify-between rounded-3xl px-3 py-2 text-lg font-medium hover:bg-accent transition-colors">Work <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="#about" @click="isMenuOpen = false" class="flex items-center justify-between rounded-3xl px-3 py-2 text-lg font-medium hover:bg-accent transition-colors">About <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="#clients" @click="isMenuOpen = false" class="flex items-center justify-between rounded-3xl px-3 py-2 text-lg font-medium hover:bg-accent transition-colors">Clients <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                <a href="#contact" @click="isMenuOpen = false" class="flex items-center justify-between rounded-3xl px-3 py-2 text-lg font-medium hover:bg-accent transition-colors">Contact <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
                
                <div class="flex flex-col gap-3 pt-4">
                    <button class="w-full inline-flex items-center justify-center rounded-3xl border border-border bg-transparent px-4 py-2 text-sm font-medium shadow-sm hover:bg-accent transition-colors">
                        Log In
                    </button>
                    <button class="w-full inline-flex items-center justify-center rounded-3xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow hover:bg-primary/90 transition-colors">
                        Get Started
                    </button>
                </div>
            </nav>
        </div>

        <main class="flex-1">
            <!-- Hero Section -->
            <section class="w-full py-12 md:py-24 lg:py-32 xl:py-48 overflow-hidden">
                <div class="container mx-auto max-w-7xl px-4 md:px-6">
                    <div class="border border-border rounded-3xl bg-gradient-to-br from-background to-muted/30 p-8 md:p-12">
                        <div class="grid gap-8 lg:grid-cols-[1fr_400px] xl:grid-cols-[1fr_600px]">
                            <div class="flex flex-col justify-center space-y-4 py-10 transition-all duration-700 opacity-100 translate-y-0">
                                <div class="space-y-3">
                                    <div class="inline-flex items-center rounded-3xl bg-muted px-3 py-1 text-sm text-foreground">
                                        <i data-lucide="zap" class="mr-1 h-3 w-3"></i> Creative Design Studio
                                    </div>
                                    <h1 class="text-4xl font-bold tracking-tighter sm:text-5xl xl:text-6xl/none">
                                        We design digital experiences that people <span class="bg-gradient-to-r from-gray-900 to-gray-500 bg-clip-text text-transparent">love</span>
                                    </h1>
                                    <p class="max-w-[600px] text-muted-foreground md:text-xl">
                                        Our award-winning team crafts beautiful, functional designs that drive growth and engagement.
                                    </p>
                                </div>
                                <div class="flex flex-col gap-3 sm:flex-row mt-6 group">
                                    <button class="inline-flex items-center justify-center rounded-3xl bg-primary px-8 py-3 text-sm font-medium text-primary-foreground shadow hover:bg-primary/90 transition-all">
                                        Get Started
                                        <i data-lucide="arrow-right" class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                                    </button>
                                    <button class="inline-flex items-center justify-center rounded-3xl border border-border bg-transparent px-8 py-3 text-sm font-medium shadow-sm hover:bg-accent transition-colors">
                                        View Our Work
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <div class="relative h-[350px] w-full md:h-[450px] lg:h-[500px] xl:h-[550px] overflow-hidden rounded-3xl">
                                    <img src="https://raw.githubusercontent.com/designali-in/designali/2a5d38f658ab24084e3260cdba2259fdc44ae2cd/apps/www/public/placeholder.svg" alt="Hero Image" class="object-cover w-full h-full rounded-3xl transition-transform hover:scale-105 duration-700" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Client Logos -->
            <section id="clients" class="w-full py-12 md:py-16 lg:py-20">
                <div class="container mx-auto max-w-7xl px-4 md:px-6">
                    <div class="border border-border rounded-3xl bg-muted/20 p-8 md:p-12">
                        <div class="flex flex-col items-center justify-center space-y-4 text-center py-6">
                            <div class="space-y-3">
                                <div class="inline-block rounded-3xl bg-muted px-3 py-1 text-sm">Trusted by</div>
                                <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">Our Clients</h2>
                                <p class="mx-auto max-w-[700px] text-muted-foreground md:text-xl/relaxed">
                                    We've had the pleasure of working with some amazing companies
                                </p>
                            </div>
                        </div>
                        <div class="mx-auto grid grid-cols-2 items-center gap-6 py-8 md:grid-cols-3 lg:grid-cols-6">
                            <!-- Loop for client logos -->
                            @for ($i = 0; $i < 6; $i++)
                            <div class="flex items-center justify-center transform transition-transform hover:scale-105">
                                <div class="rounded-3xl border border-border p-6 bg-background/80 hover:shadow-md transition-all">
                                    <img src="https://raw.githubusercontent.com/designali-in/designali/2a5d38f658ab24084e3260cdba2259fdc44ae2cd/apps/www/public/placeholder.svg?height=80&width=160" alt="Client Logo" class="grayscale transition-all hover:grayscale-0 w-32 object-contain" />
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </section>

            <!-- Services Section -->
            <section id="services" class="w-full py-12 md:py-24 lg:py-32">
                <div class="container mx-auto max-w-7xl px-4 md:px-6">
                    <div class="border border-border rounded-3xl p-8 md:p-12">
                        <div class="flex flex-col items-center justify-center space-y-4 text-center py-6">
                            <div class="space-y-3">
                                <div class="inline-block rounded-3xl bg-muted px-3 py-1 text-sm">Services</div>
                                <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">What We Do</h2>
                                <p class="mx-auto max-w-[900px] text-muted-foreground md:text-xl/relaxed">
                                    We offer a comprehensive range of design and development services to help your business thrive
                                </p>
                            </div>
                        </div>
                        
                        <div class="mx-auto grid max-w-5xl items-center gap-6 py-12 md:grid-cols-2 lg:grid-cols-3">
                            @php
                                $services = [
                                    ['icon' => 'palette', 'title' => 'UI/UX Design', 'description' => 'We create intuitive, engaging user experiences that delight your customers and drive conversions.'],
                                    ['icon' => 'code', 'title' => 'Web Development', 'description' => 'Our developers build fast, responsive, and accessible websites that work across all devices.'],
                                    ['icon' => 'sparkles', 'title' => 'Brand Identity', 'description' => 'We craft distinctive brand identities that communicate your values and resonate with your audience.'],
                                    ['icon' => 'zap', 'title' => 'Mobile Apps', 'description' => 'We design and develop native and cross-platform mobile applications that users love.'],
                                    ['icon' => 'line-chart', 'title' => 'Digital Marketing', 'description' => 'We help you reach your target audience and grow your business with data-driven marketing strategies.'],
                                    ['icon' => 'message-square', 'title' => 'Content Creation', 'description' => 'We produce engaging content that tells your story and connects with your customers.']
                                ];
                            @endphp

                            @foreach ($services as $service)
                            <div class="group relative overflow-hidden rounded-3xl border border-border p-6 shadow-sm transition-all hover:shadow-md hover:-translate-y-2 bg-background/80 duration-300">
                                <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-gray-100 group-hover:bg-gray-200 transition-all duration-300"></div>
                                <div class="relative space-y-3">
                                    <div class="mb-4"><i data-lucide="{{ $service['icon'] }}" class="h-10 w-10 text-primary"></i></div>
                                    <h3 class="text-xl font-bold">{{ $service['title'] }}</h3>
                                    <p class="text-muted-foreground">{{ $service['description'] }}</p>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <a href="#" class="text-sm font-medium text-primary underline-offset-4 hover:underline">Learn more</a>
                                    <i data-lucide="arrow-right" class="h-4 w-4 text-primary transform transition-transform group-hover:translate-x-1"></i>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Portfolio Section -->
            <section id="work" class="w-full py-12 md:py-24 lg:py-32">
                <div class="container mx-auto max-w-7xl px-4 md:px-6">
                    <div class="border border-border rounded-3xl bg-muted/10 p-8 md:p-12">
                        <div class="flex flex-col items-center justify-center space-y-4 text-center py-6">
                            <div class="space-y-3">
                                <div class="inline-block rounded-3xl bg-muted px-3 py-1 text-sm">Portfolio</div>
                                <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">Our Work</h2>
                                <p class="mx-auto max-w-[900px] text-muted-foreground md:text-xl/relaxed">
                                    A showcase of our recent projects and collaborations
                                </p>
                            </div>
                        </div>

                        <div class="mx-auto grid max-w-7xl gap-4 py-12 md:grid-cols-4 md:grid-rows-2">
                            <!-- Project 1 (Large) -->
                            <div class="group relative overflow-hidden rounded-3xl md:col-span-2 md:row-span-2 h-[400px] md:h-[auto] cursor-pointer">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-10"></div>
                                <img src="https://raw.githubusercontent.com/designali-in/designali/2a5d38f658ab24084e3260cdba2259fdc44ae2cd/apps/www/public/placeholder.svg?height=800&width=1200" alt="Portfolio 1" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 flex flex-col justify-end p-8 text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-20 translate-y-4 group-hover:translate-y-0">
                                    <h3 class="text-2xl font-bold">E-commerce Redesign</h3>
                                    <p class="text-sm text-gray-200 mt-2">A complete overhaul of an online retail platform</p>
                                    <div class="mt-4">
                                        <button class="inline-flex items-center justify-center rounded-3xl bg-white/20 backdrop-blur-md border border-white/40 px-4 py-2 text-sm font-medium text-white hover:bg-white/30 transition-colors">
                                            View Project <i data-lucide="arrow-up-right" class="ml-2 h-4 w-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project 2 -->
                            <div class="group relative overflow-hidden rounded-3xl h-[200px] md:h-[auto] cursor-pointer">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-10"></div>
                                <img src="https://raw.githubusercontent.com/designali-in/designali/2a5d38f658ab24084e3260cdba2259fdc44ae2cd/apps/www/public/placeholder.svg?height=600&width=600" alt="Portfolio 2" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-20 translate-y-4 group-hover:translate-y-0">
                                    <h3 class="text-xl font-bold">Mobile App Design</h3>
                                </div>
                            </div>
                            
                            <!-- Project 3 -->
                            <div class="group relative overflow-hidden rounded-3xl h-[200px] md:h-[auto] cursor-pointer">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-10"></div>
                                <img src="https://raw.githubusercontent.com/designali-in/designali/2a5d38f658ab24084e3260cdba2259fdc44ae2cd/apps/www/public/placeholder.svg?height=600&width=600" alt="Portfolio 3" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-20 translate-y-4 group-hover:translate-y-0">
                                    <h3 class="text-xl font-bold">Brand Identity</h3>
                                </div>
                            </div>
                            
                            <!-- Project 4 -->
                            <div class="group relative overflow-hidden rounded-3xl h-[200px] md:h-[auto] cursor-pointer">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-10"></div>
                                <img src="https://raw.githubusercontent.com/designali-in/designali/2a5d38f658ab24084e3260cdba2259fdc44ae2cd/apps/www/public/placeholder.svg?height=600&width=600" alt="Portfolio 4" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-20 translate-y-4 group-hover:translate-y-0">
                                    <h3 class="text-xl font-bold">Web Application</h3>
                                </div>
                            </div>
                            
                            <!-- Project 5 (Wide) -->
                            <div class="group relative overflow-hidden rounded-3xl md:col-span-2 h-[200px] md:h-[auto] cursor-pointer">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-10"></div>
                                <img src="https://raw.githubusercontent.com/designali-in/designali/2a5d38f658ab24084e3260cdba2259fdc44ae2cd/apps/www/public/placeholder.svg?height=600&width=1200" alt="Portfolio 5" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 flex flex-col justify-end p-6 text-white opacity-0 transition-all duration-300 group-hover:opacity-100 z-20 translate-y-4 group-hover:translate-y-0">
                                    <h3 class="text-xl font-bold">Marketing Campaign</h3>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center pb-6">
                            <button class="group inline-flex items-center justify-center rounded-3xl bg-primary px-8 py-3 text-sm font-medium text-primary-foreground shadow hover:bg-primary/90 transition-transform hover:scale-105 active:scale-95 duration-200">
                                View All Projects
                                <i data-lucide="arrow-right" class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="contact" class="w-full py-12 md:py-24 lg:py-32">
                <div class="container mx-auto max-w-7xl px-4 md:px-6">
                    <div class="grid items-center gap-8 lg:grid-cols-2 border border-border rounded-3xl p-8 md:p-12 bg-background">
                        <div class="space-y-6">
                            <div class="inline-block rounded-3xl bg-muted px-3 py-1 text-sm">Contact</div>
                            <h2 class="text-3xl font-bold tracking-tighter md:text-4xl/tight">Let's Work Together</h2>
                            <p class="max-w-[600px] text-muted-foreground md:text-xl/relaxed">
                                Ready to start your next project? Get in touch with us to discuss how we can help bring your vision to life.
                            </p>
                            
                            <div class="mt-8 space-y-6">
                                <div class="flex items-start gap-4 group cursor-pointer">
                                    <div class="rounded-3xl bg-muted p-3 transition-colors group-hover:bg-gray-200">
                                        <i data-lucide="map-pin" class="h-6 w-6 text-primary"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-lg">Our Location</h3>
                                        <p class="text-muted-foreground">123 Design Street, Creative City, 10001</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 group cursor-pointer">
                                    <div class="rounded-3xl bg-muted p-3 transition-colors group-hover:bg-gray-200">
                                        <i data-lucide="mail" class="h-6 w-6 text-primary"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-lg">Email Us</h3>
                                        <p class="text-muted-foreground">hello@designstudio.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 group cursor-pointer">
                                    <div class="rounded-3xl bg-muted p-3 transition-colors group-hover:bg-gray-200">
                                        <i data-lucide="phone" class="h-6 w-6 text-primary"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-lg">Call Us</h3>
                                        <p class="text-muted-foreground">+1 (555) 123-4567</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div class="rounded-3xl border border-border bg-background p-8 shadow-lg">
                            <h3 class="text-2xl font-bold mb-2">Send Us a Message</h3>
                            <p class="text-muted-foreground mb-6">Fill out the form below and we'll get back to you shortly.</p>
                            
                            <form class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <label for="first-name" class="text-sm font-medium">First name</label>
                                        <input type="text" id="first-name" class="flex h-10 w-full rounded-3xl border border-border bg-transparent px-4 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2" placeholder="John" />
                                    </div>
                                    <div class="space-y-2">
                                        <label for="last-name" class="text-sm font-medium">Last name</label>
                                        <input type="text" id="last-name" class="flex h-10 w-full rounded-3xl border border-border bg-transparent px-4 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2" placeholder="Doe" />
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label for="email" class="text-sm font-medium">Email</label>
                                    <input type="email" id="email" class="flex h-10 w-full rounded-3xl border border-border bg-transparent px-4 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2" placeholder="john@example.com" />
                                </div>
                                <div class="space-y-2">
                                    <label for="message" class="text-sm font-medium">Message</label>
                                    <textarea id="message" rows="4" class="flex w-full rounded-3xl border border-border bg-transparent px-4 py-3 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 resize-none" placeholder="How can we help you?"></textarea>
                                </div>
                                <button type="button" class="w-full inline-flex items-center justify-center rounded-3xl bg-primary px-4 py-3 text-sm font-medium text-primary-foreground shadow hover:bg-primary/90 transition-transform active:scale-95 mt-4">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="w-full border-t border-border mt-10">
            <div class="container mx-auto max-w-7xl px-4 py-12">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-3xl bg-primary flex items-center justify-center">
                            <i data-lucide="sparkles" class="h-5 w-5 text-primary-foreground"></i>
                        </div>
                        <span class="font-bold text-xl">Studio</span>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-muted-foreground hover:text-foreground transition-colors"><i data-lucide="instagram" class="h-5 w-5"></i></a>
                        <a href="#" class="text-muted-foreground hover:text-foreground transition-colors"><i data-lucide="twitter" class="h-5 w-5"></i></a>
                        <a href="#" class="text-muted-foreground hover:text-foreground transition-colors"><i data-lucide="linkedin" class="h-5 w-5"></i></a>
                        <a href="#" class="text-muted-foreground hover:text-foreground transition-colors"><i data-lucide="github" class="h-5 w-5"></i></a>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-border text-center text-sm text-muted-foreground">
                    &copy; {{ date('Y') }} Studio. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
    
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>

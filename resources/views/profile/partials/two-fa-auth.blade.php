  <section>
      <header>
          <h2 class="text-lg font-medium text-gray-700 dark:text-gray-100">
              {{ __('Security Advancement') }}
          </h2>
      </header>
      <form method="post" action="{{ route('settings.2fa') }}">
          @csrf

          <div class="flex items-center justify-between">
              <div>
                  <x-input-label :value="__('Two-Factor Authentication (2FA)')" />
                  <p class="text-sm text-gray-600 mt-1">
                      {{ auth()->user()->two_factor_enabled
                          ? '2FA is currently enabled for your account.'
                          : 'Enable 2FA to add an extra layer of security to your account.' }}
                  </p>
              </div>

              <div>
                @if(auth()->user()->hasVerifiedEmail())
                  <input type="hidden" name="enable_2fa" value="{{ auth()->user()->two_factor_enabled ? 0 : 1 }}">
                  <x-primary-button>
                      {{ auth()->user()->two_factor_enabled ? 'Disable 2FA' : 'Enable 2FA' }}
                  </x-primary-button>
                @else
                    <span class="text-sm text-red-600 font-medium">
                        {{ __('Please verify your email to enable 2FA.') }}
                    </span>
                @endif
              </div>
          </div>

      </form>
  </section>

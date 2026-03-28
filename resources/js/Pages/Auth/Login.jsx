import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {/* 🔥 SUCCESS MESSAGE */}
            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            {/* 🔥 ERROR MESSAGE (désactivé ou login error) */}
            {errors.email && (
                <div className="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
                    {errors.email}
                </div>
            )}

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />
                </div>

                <div className="mt-4 block">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) =>
                                setData('remember', e.target.checked)
                            }
                        />
                        <span className="ms-2 text-sm text-gray-600">
                            Remember me
                        </span>
                    </label>
                </div>

                <div className="mt-4 flex items-center justify-between">

                    {/* 🔥 REGISTER BUTTON */}
                    <Link
                        href={route('register')}
                        className="text-sm text-blue-600 hover:underline"
                    >
                        Create account
                    </Link>

                    <div className="flex items-center">

                        {canResetPassword && (
                            <Link
                                href={route('password.request')}
                                className="me-4 text-sm text-gray-600 underline hover:text-gray-900"
                            >
                                Forgot password?
                            </Link>
                        )}

                        <PrimaryButton disabled={processing}>
                            Log in
                        </PrimaryButton>

                    </div>
                </div>
            </form>
        </GuestLayout>
    );
}
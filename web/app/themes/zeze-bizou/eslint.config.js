import js from '@eslint/js'
import ts from '@typescript-eslint/eslint-plugin'
import tsParser from '@typescript-eslint/parser'
import eslintPluginUnicorn from 'eslint-plugin-unicorn'

export default [
  js.configs.recommended,
  {
    files: ['**/*.ts'],
    languageOptions: {
      parser: tsParser,
      parserOptions: {
        ecmaVersion: 2020,
        sourceType: 'module',
        // project: './tsconfig.json'
      }
    },
    plugins: {
      '@typescript-eslint': ts,
			unicorn: eslintPluginUnicorn,
		},

    rules: {
      ...ts.configs.recommended.rules
      // Vos règles custom
    }
  }
]


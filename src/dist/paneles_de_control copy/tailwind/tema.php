<script>
if (
  localStorage.theme === 'dark' ||
  (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
  document.documentElement.classList.add('dark');
} else {
  document.documentElement.classList.remove('dark');
}

document.addEventListener('DOMContentLoaded', () => {
  const toggleTheme = document.getElementById('toggleTheme');
  if (!toggleTheme) return;
  toggleTheme.addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
    localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    toggleTheme.querySelector('i').setAttribute('data-lucide', 
      document.documentElement.classList.contains('dark') ? 'sun' : 'moon');
    lucide.createIcons();
  });
});
</script>

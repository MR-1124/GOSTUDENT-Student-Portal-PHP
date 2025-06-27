</div>
    <footer class="page-footer teal darken-1">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">GOSTUDENT</h5>
                    <p class="grey-text text-lighten-4">A modern platform for managing assignments, quizzes, and notices.</p>
                </div>
                
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2025 GOSTUDENT. All rights reserved.
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidenav = document.querySelectorAll('.sidenav');
            M.Sidenav.init(sidenav);
            var modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);
            var selects = document.querySelectorAll('select');
            M.FormSelect.init(selects);
            var textareas = document.querySelectorAll('.materialize-textarea');
            M.CharacterCounter.init(textareas);
        });
    </script>
</body>
</html>
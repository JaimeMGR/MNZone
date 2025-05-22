import tkinter as tk
from tkinter import ttk, messagebox
from datetime import datetime, timedelta
import threading
import time
from database import DatabaseManager

class CountdownApp:
    def __init__(self, root):
        self.root = root
        self.root.title("MNZone - Gestión de Contadores")
        self.root.geometry("700x600")
        self.root.minsize(600, 500)
        
        self.db = DatabaseManager()
        self.current_user = None
        self.running_countdown = False
        self.paused = False
        self.countdown_thread = None
        self.start_time = None
        self.remaining_seconds = 0
        self.active_category = None
        
        # Configuración de estilo
        self.setup_styles()
        self.setup_login_ui()
    
    def setup_styles(self):
        """Configurar estilos visuales"""
        style = ttk.Style()
        style.theme_use('clam')
        
        # Colores
        self.root.configure(bg='#f0f0f0')
        style.configure('TFrame', background='#f0f0f0')
        style.configure('TLabel', background='#f0f0f0', font=('Arial', 10))
        style.configure('TButton', font=('Arial', 10), padding=5)
        style.configure('Title.TLabel', font=('Arial', 16, 'bold'), foreground='#333333')
        style.configure('Countdown.TLabel', font=('Courier New', 36, 'bold'), foreground='#2c3e50')
        style.configure('Active.TLabel', font=('Arial', 12, 'bold'), foreground='#27ae60')
        style.configure('TimeLabel.TLabel', font=('Arial', 12, 'bold'), foreground='#3498db')
        
        # Estilos para botones
        style.map('Start.TButton',
            foreground=[('active', 'white'), ('!disabled', 'white')],
            background=[('active', '#27ae60'), ('!disabled', '#2ecc71')])
        style.map('Pause.TButton',
            foreground=[('active', 'white'), ('!disabled', 'white')],
            background=[('active', '#f39c12'), ('!disabled', '#f1c40f')])
        style.map('Stop.TButton',
            foreground=[('active', 'white'), ('!disabled', 'white')],
            background=[('active', '#e74c3c'), ('!disabled', '#c0392b')])
        style.map('Logout.TButton',
            foreground=[('active', 'white'), ('!disabled', 'white')],
            background=[('active', '#7f8c8d'), ('!disabled', '#95a5a6')])
    
    def setup_login_ui(self):
        """Interfaz de inicio de sesión"""
        self.clear_window()
        
        main_frame = ttk.Frame(self.root, padding=20)
        main_frame.pack(expand=True, fill='both')
        
        # Logo o título
        title = ttk.Label(main_frame, text="MNZone", style='Title.TLabel')
        title.pack(pady=(0, 20))
        
        form_frame = ttk.Frame(main_frame)
        form_frame.pack(pady=20)
        
        # Campos de formulario
        ttk.Label(form_frame, text="Usuario:").grid(row=0, column=0, padx=5, pady=5, sticky='e')
        self.username_entry = ttk.Entry(form_frame, width=25)
        self.username_entry.grid(row=0, column=1, padx=5, pady=5)
        self.username_entry.focus()
        
        ttk.Label(form_frame, text="Contraseña:").grid(row=1, column=0, padx=5, pady=5, sticky='e')
        self.password_entry = ttk.Entry(form_frame, show="•", width=25)
        self.password_entry.grid(row=1, column=1, padx=5, pady=5)
        
        # Botón de login
        button_frame = ttk.Frame(main_frame)
        button_frame.pack(pady=10)
        
        login_btn = ttk.Button(
            button_frame, 
            text="Iniciar Sesión", 
            command=self.do_login,
            style='Start.TButton'
        )
        login_btn.pack(ipadx=20, ipady=5)
        
        # Manejar la tecla Enter
        self.root.bind('<Return>', lambda event: self.do_login())
    
    def do_login(self):
        """Verificar credenciales y mostrar interfaz principal"""
        username = self.username_entry.get().strip()
        password = self.password_entry.get().strip()
        
        if not username or not password:
            messagebox.showerror("Error", "Usuario y contraseña son requeridos")
            return
        
        try:
            user = self.db.login_user(username, password)
            if user:
                self.current_user = user
                self.setup_main_ui()
            else:
                messagebox.showerror("Error", "Credenciales incorrectas")
        except Exception as e:
            messagebox.showerror("Error", f"Ocurrió un error:\n{str(e)}")
    
    def setup_main_ui(self):
        """Interfaz principal después del login"""
        self.clear_window()
        
        # Frame principal con padding
        main_frame = ttk.Frame(self.root, padding=10)
        main_frame.pack(expand=True, fill='both')
        
        # Header con información del usuario
        header_frame = ttk.Frame(main_frame)
        header_frame.pack(fill='x', pady=(0, 10))
        
        user_info = ttk.Label(
            header_frame, 
            text=f"Usuario: {self.current_user['usuario']} ({self.current_user['tipo']})",
            style='Active.TLabel'
        )
        user_info.pack(side='left', padx=5)
        
        logout_btn = ttk.Button(
            header_frame, 
            text="Cerrar Sesión", 
            command=self.logout,
            style='Logout.TButton'
        )
        logout_btn.pack(side='right', padx=5)
        
        # Panel de tiempos disponibles
        times_frame = ttk.LabelFrame(
            main_frame, 
            text="Tiempos disponibles por sala", 
            padding=15
        )
        times_frame.pack(fill='both', expand=True, pady=5)
        
        # Mostrar tiempos para cada categoría
        self.time_labels = {}
        categories = [
            ('Sala_principal', 'Sala Principal'),
            ('Sala_VIP', 'Sala VIP'),
            ('Play_Station_5', 'PlayStation 5'),
            ('Simulador_coches', 'Simulador de Coches')
        ]
        
        for i, (category, display_name) in enumerate(categories):
            row_frame = ttk.Frame(times_frame)
            row_frame.grid(row=i, column=0, sticky='ew', pady=3)
            
            ttk.Label(
                row_frame, 
                text=f"{display_name}:",
                width=20,
                anchor='e'
            ).pack(side='left', padx=5)
            
            self.time_labels[category] = ttk.Label(
                row_frame, 
                text="0",
                style='TimeLabel.TLabel',
                width=10,
                anchor='w'
            )
            self.time_labels[category].pack(side='left')
        
        # Panel de control del contador
        control_frame = ttk.LabelFrame(
            main_frame, 
            text="Control de Contador", 
            padding=15
        )
        control_frame.pack(fill='x', pady=10)
        
        # Selección de categoría
        ttk.Label(control_frame, text="Sala:").grid(row=0, column=0, padx=5, sticky='e')
        
        self.category_var = tk.StringVar()
        self.category_combobox = ttk.Combobox(
            control_frame, 
            textvariable=self.category_var,
            values=[display for _, display in categories],
            state="readonly",
            width=20
        )
        self.category_combobox.grid(row=0, column=1, padx=5, sticky='w')
        self.category_combobox.bind("<<ComboboxSelected>>", self.on_category_selected)
        
        # Botones de control
        button_frame = ttk.Frame(control_frame)
        button_frame.grid(row=1, column=0, columnspan=2, pady=10)
        
        self.start_btn = ttk.Button(
            button_frame, 
            text="Iniciar", 
            command=self.start_countdown,
            style='Start.TButton',
            state='disabled'
        )
        self.start_btn.pack(side='left', padx=5, ipadx=15)
        
        self.pause_btn = ttk.Button(
            button_frame, 
            text="Pausar", 
            command=self.toggle_pause,
            style='Pause.TButton',
            state='disabled'
        )
        self.pause_btn.pack(side='left', padx=5, ipadx=15)
        
        self.stop_btn = ttk.Button(
            button_frame, 
            text="Detener", 
            command=self.stop_countdown,
            style='Stop.TButton',
            state='disabled'
        )
        self.stop_btn.pack(side='left', padx=5, ipadx=15)
        
        # Panel de contador activo
        self.active_countdown_frame = ttk.LabelFrame(
            main_frame, 
            text="Contador Activo", 
            padding=15
        )
        self.active_countdown_frame.pack(fill='x', pady=10)
        
        self.active_category_label = ttk.Label(
            self.active_countdown_frame, 
            text="Ninguna sala seleccionada",
            style='Active.TLabel'
        )
        self.active_category_label.pack(pady=(0, 10))
        
        self.countdown_label = ttk.Label(
            self.active_countdown_frame, 
            text="00:00:00", 
            style='Countdown.TLabel'
        )
        self.countdown_label.pack(pady=10)
        
        # Actualizar tiempos al iniciar
        self.update_times()
    
    def on_category_selected(self, event=None):
        """Cuando se selecciona una categoría, verificar si tiene tiempo disponible"""
        selected_index = self.category_combobox.current()
        if selected_index >= 0:
            categories = [cat for cat, _ in [
                ('Sala_principal', 'Sala Principal'),
                ('Sala_VIP', 'Sala VIP'),
                ('Play_Station_5', 'PlayStation 5'),
                ('Simulador_coches', 'Simulador de Coches')
            ]]
            selected_category = categories[selected_index]
            times = self.db.get_user_times(self.current_user['id_socio'])
            
            if times and times[selected_category] > 0:
                self.start_btn.config(state='normal')
            else:
                self.start_btn.config(state='disabled')
    
    def update_times(self):
        """Actualizar los tiempos mostrados en la interfaz"""
        if not self.current_user:
            return
            
        times = self.db.get_user_times(self.current_user['id_socio'])
        if times:
            for category, minutes in times.items():
                self.time_labels[category].config(text=f"{int(minutes)}")
    
    def start_countdown(self):
        """Iniciar el contador para la categoría seleccionada"""
        if self.running_countdown:
            messagebox.showwarning("Advertencia", "Ya hay un contador en ejecución")
            return
            
        selected_index = self.category_combobox.current()
        if selected_index < 0:
            messagebox.showwarning("Advertencia", "Selecciona una categoría primero")
            return
            
        categories = [cat for cat, _ in [
            ('Sala_principal', 'Sala Principal'),
            ('Sala_VIP', 'Sala VIP'),
            ('Play_Station_5', 'PlayStation 5'),
            ('Simulador_coches', 'Simulador de Coches')
        ]]
        display_names = {
            'Sala_principal': 'Sala Principal',
            'Sala_VIP': 'Sala VIP',
            'Play_Station_5': 'PlayStation 5',
            'Simulador_coches': 'Simulador de Coches'
        }
        
        selected_category = categories[selected_index]
        times = self.db.get_user_times(self.current_user['id_socio'])
        
        if not times or times[selected_category] <= 0:
            messagebox.showerror("Error", "No hay tiempo disponible para esta categoría")
            return
        
        # Configurar el contador
        self.active_category = selected_category
        self.remaining_seconds = times[selected_category] * 60
        self.start_time = datetime.now()
        self.paused = False
        
        # Actualizar la interfaz
        self.active_category_label.config(text=display_names[selected_category])
        self.update_countdown_display()
        
        # Configurar botones
        self.start_btn.config(state='disabled')
        self.pause_btn.config(state='normal')
        self.stop_btn.config(state='normal')
        self.category_combobox.config(state='disabled')
        
        # Iniciar el hilo del contador
        self.running_countdown = True
        self.countdown_thread = threading.Thread(
            target=self.run_countdown,
            daemon=True
        )
        self.countdown_thread.start()
    
    def run_countdown(self):
        """Ejecutar la cuenta atrás en segundo plano de manera segura"""
        last_update = time.time()
        
        try:
            while self.running_countdown and self.remaining_seconds > 0:
                if not self.paused:
                    current_time = time.time()
                    elapsed = current_time - last_update
                    
                    if elapsed >= 1:  # Actualizar cada segundo
                        self.remaining_seconds -= 1
                        last_update = current_time
                        # Usar after para actualizar la GUI desde el hilo principal
                        self.root.after(0, self.update_countdown_display)
                
                time.sleep(0.1)  # Pequeña pausa para reducir uso de CPU
            
            # Notificar al hilo principal que terminó
            self.root.after(0, self.countdown_finished)
        
        except Exception as e:
            print(f"Error en el hilo del contador: {e}")
            # Asegurarse de notificar al hilo principal incluso si hay error
            self.root.after(0, self.countdown_finished)
            self.root.after(0, self.countdown_finished)
    
    def update_countdown_display(self):
        """Actualizar la visualización del contador"""
        hours, remainder = divmod(self.remaining_seconds, 3600)
        minutes, seconds = divmod(remainder, 60)
        time_str = f"{int(hours):02d}:{int(minutes):02d}:{int(seconds):02d}"
        self.countdown_label.config(text=time_str)
    
    def toggle_pause(self):
        """Pausar o reanudar el contador"""
        self.paused = not self.paused
        if self.paused:
            self.pause_btn.config(text="Reanudar")
        else:
            self.pause_btn.config(text="Pausar")
    
    def stop_countdown(self):
        """Detener el contador manualmente de manera segura"""
        if not self.running_countdown:
            return
        
        # Primero detener el flag para que el hilo sepa que debe terminar
        self.running_countdown = False
        
        # Esperar al hilo con un timeout para evitar bloqueos
        if self.countdown_thread and self.countdown_thread.is_alive():
            self.countdown_thread.join(timeout=1.0)  # Esperar máximo 1 segundo
            
            if self.countdown_thread.is_alive():
                print("Advertencia: El hilo del contador no terminó correctamente")
        
        # Ahora limpiar y actualizar la interfaz desde el hilo principal
        self.root.after(0, self.countdown_finished)
    
    def countdown_finished(self):
        """Manejar la finalización del contador de manera segura"""
        if not self.running_countdown and not self.paused:
            return  # Evitar múltiples llamadas
        
        # Calcular tiempo utilizado
        end_time = datetime.now()
        seconds_used = 0
        
        try:
            if self.start_time and self.active_category:
                if self.remaining_seconds > 0:
                    # Contador detenido manualmente
                    original_seconds = self.db.get_user_times(
                        self.current_user['id_socio']
                    )[self.active_category] * 60
                    seconds_used = original_seconds - self.remaining_seconds
                else:
                    # Contador terminó naturalmente
                    seconds_used = self.db.get_user_times(
                        self.current_user['id_socio']
                    )[self.active_category] * 60
                
                # Actualizar la base de datos
                if seconds_used > 0:
                    success = self.db.update_time(
                        self.current_user['id_socio'],
                        self.active_category,
                        seconds_used
                    )
                    
                    if success:
                        # Registrar el uso
                        self.db.log_usage(
                            self.current_user['id_socio'],
                            self.active_category,
                            self.start_time,
                            end_time,
                            seconds_used
                        )
                    else:
                        self.root.after(0, lambda: messagebox.showerror(
                            "Error", "No se pudo actualizar el tiempo"))
        
        except Exception as e:
            print(f"Error al finalizar contador: {e}")
            self.root.after(0, lambda: messagebox.showerror(
                "Error", f"Ocurrió un error: {str(e)}"))
        
        finally:
            # Restablecer el estado siempre
            self.running_countdown = False
            self.paused = False
            
            # Actualizar la interfaz desde el hilo principal
            self.root.after(0, self._cleanup_countdown_ui)
            
            # Mostrar mensaje según cómo terminó
            if seconds_used > 0 and self.remaining_seconds <= 0:
                self.root.after(0, lambda: messagebox.showinfo(
                    "Info", "¡Tiempo agotado!"))

    def _cleanup_countdown_ui(self):
        """Limpieza segura de la interfaz de usuario"""
        self.active_category = None
        self.start_time = None
        
        self.active_category_label.config(text="Ninguna sala seleccionada")
        self.countdown_label.config(text="00:00:00")
        
        self.start_btn.config(state='normal')
        self.pause_btn.config(state='disabled', text="Pausar")
        self.stop_btn.config(state='disabled')
        self.category_combobox.config(state='readonly')
        
        # Actualizar los tiempos mostrados
        self.update_times()
    
    def logout(self):
        """Cerrar sesión y volver a la pantalla de login"""
        if self.running_countdown:
            if messagebox.askyesno(
                "Confirmar", 
                "Hay un contador activo. ¿Seguro que quieres cerrar sesión?"
            ):
                self.stop_countdown()
            else:
                return
        
        self.current_user = None
        self.setup_login_ui()
    
    def clear_window(self):
        """Limpiar todos los widgets de la ventana"""
        for widget in self.root.winfo_children():
            widget.destroy()

if __name__ == "__main__":
    root = tk.Tk()
    app = CountdownApp(root)
    
    # Centrar la ventana
    window_width = 700
    window_height = 600
    screen_width = root.winfo_screenwidth()
    screen_height = root.winfo_screenheight()
    center_x = int(screen_width/2 - window_width/2)
    center_y = int(screen_height/2 - window_height/2)
    root.geometry(f'{window_width}x{window_height}+{center_x}+{center_y}')
    
    root.mainloop()
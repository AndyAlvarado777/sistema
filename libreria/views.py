from django.shortcuts import render, redirect
from django.http import HttpResponse
from .models import Libro
from .forms import LibroForm

def inicio(request):
    return render(request, 'pagina/inicio.html')

def about(request):
    return render(request, 'pagina/about.html')

def libros(request):
    libros = Libro.objects.all()
    return render(request, 'Libros/index.html', {'libros': libros})

def crear(request):
    formulario = LibroForm(request.POST or None, request.FILES or None)
    if formulario.is_valid():
        formulario.save()
        return redirect('libros')
    return render(request, 'Libros/Crear.html', {'formulario': formulario})


def editar(request,id):
    libro_obj = Libro.objects.get(id=id)  # creo un objeto con el id que recibo del modelo Libro
    formulario = LibroForm(request.POST or None, request.FILES or None, instance=libro_obj)
    if formulario.is_valid() and request.POST:
        formulario.save()
        return redirect('libros')
        
    return render(request, 'Libros/Editar.html', {'formulario': formulario})
    

def eliminar(request, id): 
    libro_obj = Libro.objects.get(id=id)  # creo un objeto con el id que recibo del modelo Libro
    libro_obj.delete()
    return redirect('libros')

# Create your views here.

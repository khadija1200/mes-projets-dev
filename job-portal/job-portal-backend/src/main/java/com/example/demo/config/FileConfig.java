package com.example.demo.config;

import org.springframework.context.annotation.Configuration;
import org.springframework.web.servlet.config.annotation.ResourceHandlerRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;

import java.nio.file.Paths;

@Configuration
public class FileConfig implements WebMvcConfigurer {

    @Override
    public void addResourceHandlers(ResourceHandlerRegistry registry) {

        String uploadPath = Paths.get("uploads")
                .toAbsolutePath()
                .toString();

        // 🔥 FIX : on expose uploads dans l'URL
        registry.addResourceHandler("/files/uploads/**")
                .addResourceLocations("file:" + uploadPath + "/");
    }
}